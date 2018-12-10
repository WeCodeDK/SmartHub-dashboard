<?php

namespace App\Events\Deploy;

use App\Events\DashboardEvent;

class DeployKpi extends DashboardEvent
{
    /** @var array */
    public $kpi;

    public function __construct(array $kpi)
    {
        $this->kpi = $kpi;
    }
}
