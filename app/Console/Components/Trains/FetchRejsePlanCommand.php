<?php

namespace App\Console\Components\Trains;

use App\Events\Trains\TrainDataFetched;
use App\Helpers\RejseplanAPI;
use Illuminate\Console\Command;


class FetchRejsePlanCommand extends Command
{
    protected $signature = 'dashboard:fetch-train-rejseplan';

    protected $description = 'Fetch Rejseplan Information';

    public function handle(RejseplanAPI $rejseplan)
    {
        $this->info('Fetching trainConnections from Rejseplanen...');

        $trains = $rejseplan->data();


        event(new TrainDataFetched($trains));

        $this->info('All done!');
    }
}
