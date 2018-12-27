<?php

namespace App\Events\Trains;

use App\Events\DashboardEvent;

class TrainDataFetched extends DashboardEvent
{
    /** @var array */
    public $trainData;

    public function __construct(array $trainData)
    {
        $this->trainData = $trainData;
    }
}
