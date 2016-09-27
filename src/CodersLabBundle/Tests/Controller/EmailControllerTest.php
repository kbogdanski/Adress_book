<?php

namespace CodersLabBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailControllerTest extends WebTestCase
{
    public function testAddemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/addEmail');
    }

    public function testModifyemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/modifyEmail');
    }

    public function testDeleteemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}/deleteEmail');
    }

}
