<?php

namespace App\Events\Lunch;

use App\Events\DashboardEvent;
use App\Models\Lunch;
use Illuminate\Database\Eloquent\Collection;

class LunchFetched extends DashboardEvent
{
    /** @var array */
    public $lunch;

    public function __construct(Collection $lunch)
    {
        $this->lunch = $lunch;
    }
}
