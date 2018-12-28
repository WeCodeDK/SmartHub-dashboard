<?php

namespace App\Helpers\Scraping;

use App\Models\Lunch;
use Carbon\Carbon;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class LunchScraper
{


    private function client()
    {
        return new Client();
    }

    public function getLunch()
    {
        $data = array();

        $client = $this->client();
        $crawler = $client->request('GET', 'https://app.frokostfirmaet.dk/da');

        $form = $crawler->selectButton('Log-ind')->form();

        $crawler = $client->submit($form, array('user[email]' => 'camilla@wecode.dk', 'user[password]' => 'wecode123'));

        $crawler = $client->request('GET','https://app.frokostfirmaet.dk/da/customer/kitchens/868');

        $link = $crawler->filter('li')->last()->children('a')->link();

        $crawler = $client->click($link);

        $data = $crawler->filter('.col-md-12 > .ibox')->each(function( $node, $i) use ($data){
            $date = $node->filter('.ibox-title > h5 > small')->text();

            $data[$date] = array();

            $food_item = $node->filter('.feed-element')->each(function( $node, $i) use ($data, $date){
             return  [
                 'headline' => $node->filter('.media-body > strong')->text(),
                 'body' => $node->filter('.frok-menu-item')->text(),
                 'image_url' => $node->filter('.img-circle')->attr('src'),
                 'lunch_date' => Carbon::parse($date)
                ];
            });
            array_push($data[$date], $food_item );
            return $data;
        });

        return $data;



        //dd($crawler);
    }

    public function getLunchAndPersist()
    {
        $data = $this->getLunch();
        foreach ($data as $datum) {
            foreach ($datum as $lunch_item) {
                foreach ($lunch_item as $item) {
                    foreach ($item as $i){
                        // dd($i);
                        Lunch::updateOrCreate(
                            ['lunch_date' => $i['lunch_date'], 'body' => $i['body']],
                            $i
                        );
                    }
                }
            }
        }
    }
}