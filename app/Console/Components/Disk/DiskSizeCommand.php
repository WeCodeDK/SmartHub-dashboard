<?php
/**
 * Created by PhpStorm.
 * User: alexanderlindkjaer
 * Date: 2019-03-02
 * Time: 16:51
 */

namespace App\Console\Components\Disk;

use App\Models\DiskSize;
use Illuminate\Console\Command;
use App\Events\Disk\DiskSizeFetched;

class DiskSizeCommand extends Command
{
    protected $signature = 'dashboard:fetch-disk';

    protected $description = 'Fetch Disk Information';

    public function handle()
    {
        $disks = DiskSize::get();

        foreach ($disks as $disk) {
            $disk->size_data = json_decode($disk->size_data);
            $disk->disk = null;
            $top = 0;

            //determine wich mount to look at based on biggest usage
            foreach ($disk->size_data as $mount) {
                if (!str_contains($mount->used, 'G')) {
                    continue;
                }
                $gigs = (int) preg_replace("/^[0-9]{1,2}([,.][0-9]{1,2})?$/", "", $mount->used);
                //echo $gigs.' '.$top."\n";
                if ($gigs > $top) {
                    $top = $gigs;
                    $disk->disk = $mount;
                }
            }

            //set disk size data is ints instead of string
            if ($disk->disk) {
                $disk->disk->used = (int) preg_replace("/^[0-9]{1,2}([,.][0-9]{1,2})?$/", "", $disk->disk->used);
                $disk->disk->spacetotal = (int) preg_replace("/^[0-9]{1,2}([,.][0-9]{1,2})?$/", "", $disk->disk->spacetotal);
                $disk->disk->rate = (int) ($disk->disk->used / ($disk->disk->spacetotal / 100));
                $disk->disk_rate = $disk->disk->rate;
            }
        }

        //sort by % used
        $arr = $disks->toArray();
        usort($arr, function($a, $b)
        {
            return $b['disk_rate'] <=> $a['disk_rate'];
        });

        $this->info('Collecting disk sizes...');
        event(new DiskSizeFetched($arr));
    }
}
