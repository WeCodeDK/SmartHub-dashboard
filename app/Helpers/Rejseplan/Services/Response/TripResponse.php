<?php

namespace App\Helpers\Rejseplan\Services\Response;

use JMS\Serializer\Annotation as Serializer;
use App\Helpers\Rejseplan\Services\Response\Trip\Leg;

class TripResponse
{
    /**
     * Legs for this trip.
     *
     * @var Leg[]
     * @Serializer\Type("array<RejseplanApi\Services\Response\Trip\Leg>")
     */
    protected $legs = [];

    /**
     * Time when departure.
     *
     * @var \DateTime
     * @Serializer\Type("DateTime")
     */
    protected $departureDate;

    /**
     * Time on arrival.
     *
     * @var \DateTime
     * @Serializer\Type("DateTime")
     */
    protected $arrivalDate;

    /**
     * @return Trip\Leg[]
     */
    public function getLegs()
    {
        return $this->legs;
    }

    /**
     * @return \DateTime
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * @param array $data
     *
     * @return TripResponse
     */
    public static function createFromArray(array $data)
    {
        $obj = new self();
        $legs = [];
        $firstLegTime = null;
        $lastLegTime = null;
        $legNumber = 0;
        //foreach ($data['Leg'] as $leg) {
            $legData = Leg::createFromArray($data['Leg']);
            $legs[] = $legData;

            if (++$legNumber === 1) {
                $ld = $legData->getOrigin();
                $firstLegTime = $ld ? $ld->getDate() : null;
            }

            $ld = $legData->getDestination();
            $lastLegTime = $ld ? $ld->getDate() : null;
        //}

        $obj->legs = $legs;
        $obj->departureDate = $firstLegTime;
        $obj->arrivalDate = $lastLegTime;

        return $obj;
    }

    public function toArray() {
        $vars = get_object_vars ( $this );
        $array = array ();
        foreach ( $vars as $key => $value ) {
            $array [ltrim ( $key, '_' )] = $value;
        }
        return $array;
    }
}
