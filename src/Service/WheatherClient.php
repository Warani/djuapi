<?php
/**
 * Created by PhpStorm.
 * User: lpu
 * Date: 12/29/17
 * Time: 2:29 PM
 */

namespace App\Service;


use GuzzleHttp\Client;

class WheatherClient
{
    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    public function getClient(){
        return $this->client;
    }
}