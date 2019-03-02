<?php
/**
 * Created by PhpStorm.
 * User: alexanderlindkjaer
 * Date: 2018-12-09
 * Time: 18:04
 */

namespace App\Http\Controllers;

use App\Models\DiskSize;
use Illuminate\Http\Request;

class DiskWebhookController
{
    public function diskUpload(Request $request)
    {
        $string = $request->getContent();
        $data = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $string), true);

        $size = DiskSize::where('server_name', $data['servername'])->first();

        if ($size) {
            $size->update(['size_data' => json_encode($data['dh']['diskarray'])]);
        } else {
            $size = DiskSize::create(['server_name' => $data['servername'], 'size_data' => json_encode($data['dh']['diskarray'])]);
        }
        
        return response()->json($request->all());
    }
}
