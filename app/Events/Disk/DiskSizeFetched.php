<?php
namespace App\Events\Disk;

use App\Events\DashboardEvent;
use Illuminate\Database\Eloquent\Collection;

class DiskSizeFetched extends DashboardEvent
{
    /** @var array */
    public $diskSizes;

    public function __construct($diskSizes)
    {
        $this->diskSizes = $diskSizes;
    }
}
