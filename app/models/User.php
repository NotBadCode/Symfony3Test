<?php

namespace app\models;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class User
 * @ORM\Entity(repositoryClass="app\repositories\UserRepository")
 * @Entity @Table(name="users")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $username;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $password;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $token;

    /**
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
                             $this->id,
                             $this->username,
                         ]);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            ) = unserialize($serialized);
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }
}