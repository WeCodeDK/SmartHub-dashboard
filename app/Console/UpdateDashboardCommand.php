<?php

namespace App\Console;

use Illuminate\Console\Command;

class UpdateDashboardCommand extends Command
{
    protected $signature = 'dashboard:update';

    protected $description = 'Update all components displayed on the dashboard.';

    public function handle()
    {
        $this->call('dashboard:determine-appearance');
        $this->call('dashboard:dashboard:fetch-lunch');
        $this->call('dashboard:fetch-train-rejseplan');
        $this->call('dashboard:send-heartbeat');


    }
}
