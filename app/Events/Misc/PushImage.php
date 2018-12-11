<?php

namespace App\Events\Misc;

use App\Events\DashboardEvent;

class PushImage extends DashboardEvent
{
    /** @var string */
    public $image_url;

    public function __construct(string $image_url)
    {
        $this->image_url = $image_url;
    }
}
