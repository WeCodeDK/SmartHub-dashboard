<?php

namespace App\Helpers\Rejseplan\Services\Response;

use JMS\Serializer\Annotation as Serializer;
use RejseplanApi\Services\AbstractServiceCall;
use RejseplanApi\Services\Response\StationBoard\BoardData;

class ArrivalBoardResponse
{
    /**
     * The list of departures from the location.
     *
     * @var BoardData[]
     * @Serializer\Type("array<RejseplanApi\Services\Response\StationBoard\BoardData>")
     */
    protected $arrivals = [];

    /**
     * To get the next departures, use this date.
     *
     * @var \DateTime
     * @Serializer\Type("DateTime")
     */
    protected $nextBoardDate;

    /**
     * @return BoardData[]
     */
    public function getArrivals()
    {
        return $this->arrivals;
    }

    /**
     * @return \DateTime
     */
    public function getNextBoardDate()
    {
        return $this->nextBoardDate;
    }

    /**
     * @param array $data
     *
     * @return ArrivalBoardResponse
     */
    public static function createFromArray(array $data)
    {
        $obj = new self();
        $lastDate = null;

        if (!isset($data['Arrival'])) {
            return $obj;
        }

        $arrivals = AbstractServiceCall::checkForSingle($data['Arrival'], 'name');
        foreach ($arrivals as $arrival) {
            $dep = BoardData::createFromArray($arrival);
            $obj->arrivals[] = $dep;

            $lastDate = $dep->getScheduledDate();
            if ($dep->isDelayed()) {
                $lastDate = $dep->getRealDate();
            }
        }
        $obj->nextBoardDate = $lastDate;

        return $obj;
    }
}
