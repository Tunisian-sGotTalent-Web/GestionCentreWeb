<?php

namespace CentreBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailControllerTest extends WebTestCase
{
    public function testSendmail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendMail');
    }

}
