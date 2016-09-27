<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GroupControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');
    }

    public function testGroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/group');
    }

    public function testDeletegroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/deleteGroup');
    }

    public function testAddpersontogroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addPersonToGroup');
    }

    public function testDeletepersonforgroup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deletePersonForGroup');
    }

}
