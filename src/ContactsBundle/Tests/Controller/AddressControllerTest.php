<?php

namespace ContactsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressControllerTest extends WebTestCase
{
    public function testAddaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addAddress');
    }

    public function testEditaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editAddress');
    }

    public function testDeleteaddress()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteAddress');
    }

    public function testShowalladdresses()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllAddresses');
    }

}
