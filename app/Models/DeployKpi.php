<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeployKpi extends Model
{
    protected $fillable = [
      'date',
      'total'
    ];

    public static function newDeploy()
    {
        $now = Carbon::now();
        $date = self::whereDate('date', $now)->first();

        if(!$date){
            $date = self::create([
                'date' => $now,
                'total' => 0
            ]);
        }

        $date->increment('total');

    }


    public static function getStats(){
        $now = Carbon::now();
        return [
            'daily' => call_user_func(function() use($now){
                $kpi = self::whereDate('date', $now)->first();
                if($kpi) return $kpi->total;
                return 0;
            }),
            'weekly' => call_user_func(function() use($now){
                $kpi = self::whereDate('date', '>=', $now->startOfWeek())->whereDate('date', '<=', $now->endOfWeek())->get();
                return (int) $kpi->sum('total');
            }),
            'monthly' => call_user_func(function() use($now){
                $kpi = self::whereDate('date', '>=', $now->startOfMonth())->whereDate('date', '<=', $now->endOfMonth())->get();
                return (int) $kpi->sum('total');
            }),
            'yearly' => call_user_func(function() use($now){
                $kpi = self::whereDate('date', '>=', $now->startOfYear())->whereDate('date', '<=', $now->endOfYear())->get();
                return (int) $kpi->sum('total');
            }),

        ];
    }
}
