<?php

namespace App\Helpers\Rejseplan\Services\Response\Trip;

use JMS\Serializer\Annotation as Serializer;

class Leg
{
    /**
     * Leg name.
     *
     * @var string
     * @Serializer\Type("string")
     */
    protected $name;

    /**
     * Leg type.
     *
     * @var string
     * @Serializer\Type("string")
     */
    protected $type;

    /**
     * Leg origin.
     *
     * @var Place
     * @Serializer\Type("Place")
     */
    protected $origin;

    /**
     * Leg destination.
     *
     * @var Place
     * @Serializer\Type("Place")
     */
    protected $destination;

    /**
     * Notes for this leg.
     *
     * @var array
     * @Serializer\Type("array")
     */
    protected $notes;

    /**
     * Url to leg details.
     *
     * @var string
     * @Serializer\Type("string")
     */
    protected $journyDetails;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Place
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return Place
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return array
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return string
     */
    public function getJournyDetails()
    {
        return $this->journyDetails;
    }

    /**
     * @param array $data
     *
     * @return Leg
     */
    public static function createFromArray(array $data)
    {
        $obj = new self();

//        if(!isset($data['name'])){
//            dd($data);
//        };

        $obj->name = isset($data['name']) ? $data['name'] : 'No name';
        $obj->type = isset($data['type']) ? $data['type'] : 'No type';
        $obj->origin = isset($data['Origin']) ? Place::createFromArray($data['Origin']) : null;
        $obj->destination = isset($data['Destination']) ? Place::createFromArray($data['Destination']) : null;

        if (isset($data['Notes'], $data['Notes']['text'])) {
            $obj->notes = self::setNotes($data['Notes']['text'], $data['type']);
        }

        if (isset($data['JourneyDetailRef'], $data['JourneyDetailRef']['ref'])) {
            $obj->journyDetails = $data['JourneyDetailRef']['ref'];
        }

        return $obj;
    }

    private static function setNotes($notes, $type)
    {
        $split = '/[;,]/';
        if ($type == 'BIKE') {
            $split = '/[;]/';
        }

        $splitted = preg_split($split, $notes);
        $splitted = array_filter($splitted, function ($value) {
            return $value !== '';
        });

        return $splitted;
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
