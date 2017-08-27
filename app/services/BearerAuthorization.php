<?php

namespace app\services;

use app\models\User;
use Symfony\Component\HttpFoundation\Request;

class BearerAuthorization
{
    /**
     * @var Doctrine $doctrine
     */
    protected $doctrine;

    /**
     * @var string $tokenName
     */
    protected $tokenName;

    public function __construct($tokenName, Doctrine $doctrine)
    {
        $this->tokenName = $tokenName;
        $this->doctrine  = $doctrine;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function checkAuth(Request $request)
    {
        $authHeader = $request->headers->get('Authorization', '');

        preg_match('/^Bearer\s+(.*?)$/', $authHeader, $token);

        if (!empty($token[1])) {
            $user = $this->doctrine->entityManager->getRepository(User::class)
                                                  ->findOneBy([$this->tokenName => $token[1]]);
            if (null !== $user) {
                return true;
            }
        }

        return false;
    }
}