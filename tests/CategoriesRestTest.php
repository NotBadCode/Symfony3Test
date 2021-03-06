<?php

namespace tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class CategoriesRestTest extends TestCase implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $container = include __DIR__ . '/../config/container.php';

        $this->setContainer($container);
    }

    public function testPostGetPutDelete()
    {
        /**
         * @var \app\services\Doctrine $doctrine
         */
        $doctrine = $this->container->get('doctrine');
        $user     = new \app\models\User();
        $user->setUsername(bin2hex(random_bytes(4)));
        $user->setPassword(bin2hex(random_bytes(4)));
        $token = bin2hex(random_bytes(16));
        $user->setToken($token);

        $client = new Client();
        $data   = [
            'title' => bin2hex(random_bytes(4)),
        ];

        $doctrine->entityManager->persist($user);
        $doctrine->entityManager->flush();

        $response = $client->request('POST',
                                     'http://etest.local/category',
                                     [
                                         'headers' => ['Authorization' => "Bearer $token"],
                                         'json'    => $data
                                     ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody(), true);
        $body = json_decode($body, true);
        $this->assertArrayHasKey('id', $body);

        $id = $body['id'];

        $response = $client->request('GET',
                                     "http://etest.local/category/$id");
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody(), true);
        $body = json_decode($body, true);
        $this->assertArrayHasKey('id', $body);
        $this->assertEquals($id, $body['id']);

        $newTitle      = bin2hex(random_bytes(4));
        $data['title'] = $newTitle;
        $response      = $client->request('PUT',
                                          "http://etest.local/category/$id",
                                          [
                                              'headers' => ['Authorization' => "Bearer $token"],
                                              'json'    => $data
                                          ]);
        $this->assertEquals(200, $response->getStatusCode());
        $body = json_decode($response->getBody(), true);
        $body = json_decode($body, true);
        $this->assertArrayHasKey('title', $body);
        $this->assertEquals($newTitle, $body['title']);

        $response = $client->request('DELETE',
                                     "http://etest.local/category/$id",
                                     [
                                         'headers' => ['Authorization' => "Bearer $token"],
                                     ]);

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testList()
    {
        $client = new Client();

        $response = $client->request('GET',
                                     'http://etest.local/category',
                                     []);


        $this->assertEquals(200, $response->getStatusCode());
    }
}