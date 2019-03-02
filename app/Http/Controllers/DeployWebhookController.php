<?php
/**
 * Created by PhpStorm.
 * User: alexanderlindkjaer
 * Date: 2018-12-09
 * Time: 18:04
 */

namespace App\Http\Controllers;

use App\Events\Deploy\ForgeDeploy;
use App\Models\DeployKpi;
use Illuminate\Http\Request;

class DeployWebhookController
{
    public function forgeDeploy(Request $request)
    {
        event(new ForgeDeploy($request->all()));

        DeployKpi::newDeploy();
        $stats = DeployKpi::getStats();
        event((new \App\Events\Deploy\DeployKpi($stats)));


        return response()->json($request->all());
    }


}