<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdresControllerTest extends WebTestCase
{
    public function testAdadres()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/addAdres');
    }

    public function testModifyadres()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/modifyAdres');
    }

    public function testDeleteadres()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/deleteAdres');
    }

}
