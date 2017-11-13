<?php

namespace ContactsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    public function testAddgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addGroup');
    }

    public function testEditgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editGroup');
    }

    public function testDeletegroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteGroup');
    }

    public function testShowallgroups()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testShowusersofgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showUsersOfGroup');
    }

}
