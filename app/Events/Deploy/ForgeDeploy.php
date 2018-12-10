<?php

namespace App\Events\Deploy;

use App\Events\DashboardEvent;

class ForgeDeploy extends DashboardEvent
{
    /** @var array */
    public $deployProperties;

    public function __construct(array $deployProperties)
    {
        $this->deployProperties = $deployProperties;
    }
}
