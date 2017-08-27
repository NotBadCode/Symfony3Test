<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $container = include __DIR__ . '/../config/container.php';

    /**
     * @var \app\services\Doctrine $doctrine
     */
    $doctrine = $container->get('doctrine');

    $user     = new \app\models\User();
    $username = bin2hex(random_bytes(4));
    $user->setUsername($username);
    $password = bin2hex(random_bytes(4));
    $user->setPassword(md5($password));
    $token = bin2hex(random_bytes(16));
    $user->setToken($token);

    $doctrine->entityManager->persist($user);
    $doctrine->entityManager->flush();

    echo "Username: $username; Password: $password; Token: $token \n";
} catch (Exception $exception) {
    echo $exception->getMessage();
}