<?php

namespace App\Helpers;

use Carbon\Carbon;
use RejseplanApi\Services\ArrivalBoard;
use RejseplanApi\Services\Location;

class RejseplanAPI
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = 'http://xmlopen.rejseplanen.dk/bin/rest.exe';
    }

    public function data()
    {
        $data = array();

        $data['Snekkersten'] = $this->trip('Nørreport St.', 'Snekkersten St.');
        $data['Farum'] = $this->trip('Nørreport St.', 'Farum St.');
        $data['Helsingør'] = $this->trip('Nørreport St.', 'Helsingør St.');

        return $data;
    }

    public function arrivalBoard()
    {
        $location = $this->location('Nørreport St.');
        dd($location);

        $board = new ArrivalBoard($this->base_url);
        $board->setLocation($location);
        $response = $board->call();
        dd($response);
    }

    private function location($location)
    {
        $board = new \App\Helpers\Rejseplan\Services\Location($this->base_url);
        $board->setInput($location);
        $board->setNoPois();
        $response = $board->call();
        return $response[0];
    }

    public function trip($origin, $dest)
    {
        $origin_response = $this->location($origin);
        $dest_response = $this->location($dest);


        $trip = new \App\Helpers\Rejseplan\Services\Trip($this->base_url);
        $trip->setOrigin($origin_response);
        $trip->setDestination($dest_response);

        $response = $trip->call();

        $data = array();

        foreach ($response as $r) {

            $d = array();
            $d['arrival'] = $r->getArrivalDate();
            $d['departure'] = $r->getDepartureDate();
            $d['legs'] = $r->getLegs()[0]->toArray();

            $d['legs']['origin'] = $d['legs']['origin']->toArray();
            $d['legs']['destination'] = $d['legs']['destination']->toArray();

            array_push($data, (array)$d);
        }

        return $data;

    }

}