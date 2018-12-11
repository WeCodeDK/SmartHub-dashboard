<?php

namespace App\Http\Controllers;

use App\Events\Dashboard\ReloadDashboard;
use App\Events\Misc\PushImage;
use App\Services\TweetHistory\TweetHistory;
use Illuminate\Http\Request;

class MiscController
{
    public function reload(Request $request)
    {
        event(new ReloadDashboard());
        return response()->json($request->all());
    }

    public function pushImage(Request $request)
    {
        $request->validate([
            'image_url' => 'required',
        ]);

        event(new PushImage($request->image_url));
        return response()->json($request->all());
    }
}
