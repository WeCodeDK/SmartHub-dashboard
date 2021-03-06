<?php

namespace App\Helpers\Rejseplan\Services;

use Psr\Http\Message\ResponseInterface;
use App\Helpers\Rejseplan\Services\Response\LocationResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The location service can be used to perform a pattern matching of a user input and to
 * retrieve a list of possible matches in the journey planner database. Possible matches
 * might be stops/stations, points of interest and addresses.
 */
class Location extends AbstractServiceCall
{
    /**
     * Set user input for a location search.
     *
     * @param string $input user input to find a location, which can be stations, POIs and adresses
     *
     * @return $this
     */
    public function setInput($input)
    {
        $this->options['input'] = $input;

        return $this;
    }

    /**
     * If set the search will not have any stops.
     *
     * @return $this
     */
    public function setNoStops()
    {
        $this->options['include_stops'] = false;

        return $this;
    }

    /**
     * If set the search will not have any addresses.
     *
     * @return $this
     */
    public function setNoAddresses()
    {
        $this->options['include_addresses'] = false;

        return $this;
    }

    /**
     * If set the search will not have any pois.
     *
     * @return $this
     */
    public function setNoPois()
    {
        $this->options['include_pois'] = false;

        return $this;
    }

    /**
     * Configure the options.
     *
     * @param OptionsResolver $options
     */
    protected function configureOptions(OptionsResolver $options)
    {
        $options->setRequired(['input', 'include_stops', 'include_addresses', 'include_pois']);
        $options->setAllowedTypes('input', ['string', 'int', 'float']);
        $options->setAllowedTypes('include_stops', 'bool');
        $options->setAllowedTypes('include_addresses', 'bool');
        $options->setAllowedTypes('include_pois', 'bool');

        $options->setDefault('include_stops', true);
        $options->setDefault('include_addresses', true);
        $options->setDefault('include_pois', true);
    }

    /**
     * Create the URL.
     *
     * @param array $options
     *
     * @return string
     */
    protected function getUrl(array $options)
    {
        return sprintf('location?input=%s&format=json', urlencode($options['input']));
    }

    /**
     * Generate the response object.
     *
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function generateResponse(ResponseInterface $response)
    {
        $json = $this->validateJson($response);

        $output = [];
        if (!isset($json['LocationList'])) {
            return $output;
        }

        foreach ($json['LocationList'] as $type => $stops) {
            if ($type == 'noNamespaceSchemaLocation') {
                continue;
            }

            $stops = $this->checkForSingle($stops, 'name');
            foreach ($stops as $stop) {
                $this->setAllowed($stop, $output);
            }
        }

        return $output;
    }

    /**
     * Call it.
     *
     * @return LocationResponse[]
     */
    public function call()
    {
        return $this->doCall();
    }

    private function setAllowed($stop, array &$output)
    {
        $location = LocationResponse::createFromArray($stop);
        $types = ['include_stops' => 'isStop', 'include_addresses' => 'isAddress', 'include_pois' => 'isPoi'];
        foreach ($types as $type => $method) {
            if ($this->options[$type] === true) {
                if ($location->{$method}()) {
                    $output[] = $location;
                    break;
                }
            }
        }
    }
}
