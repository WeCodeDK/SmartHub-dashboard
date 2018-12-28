<?php

namespace App\Console\Components\Scraper;

use App\Events\Lunch\LunchFetched;
use App\Helpers\Scraping\LunchScraper;
use App\Models\Lunch;
use Carbon\Carbon;
use Illuminate\Console\Command;


class LunchCommand extends Command
{
    protected $signature = 'dashboard:fetch-lunch';

    protected $description = 'Fetch Lunch Information';

    public function handle(LunchScraper $lunchScraper)
    {
        $this->info('Scraping lunch...');


        $lunch = Lunch::whereDate('lunch_date', Carbon::now()->format('Y-m-d'))->get();

        if (count($lunch) > 0) {
            event( new LunchFetched($lunch));
        } else {
            $lunchScraper->getLunchAndPersist();

            $lunch = Lunch::whereDate('lunch_date', '2018-12-17')->get();
            event( new LunchFetched($lunch));
        }


        // event(new TrainConnectionsFetched($trainConnections));


        $this->info('All done!');
    }
}
