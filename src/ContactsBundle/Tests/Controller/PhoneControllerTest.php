<?php

namespace ContactsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhoneControllerTest extends WebTestCase
{
    public function testAddphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addPhone');
    }

    public function testEditphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPhone');
    }

    public function testDeletephone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletePhone');
    }

    public function testShowallphones()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showAllPhones');
    }

}
