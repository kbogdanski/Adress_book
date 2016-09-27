<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhoneControllerTest extends WebTestCase
{
    public function testAddphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/addPhone');
    }

    public function testModifyphone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/modifyPhone');
    }

    public function testDeletephone()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/deletePhone');
    }

}
