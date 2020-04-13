<?php

namespace CentreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SessionControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
    }

    public function testAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
    }

}
