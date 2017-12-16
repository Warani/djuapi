<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @MongoDB\Id()
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=false)
     */
    private $username;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=false)
     */
    private $password;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=false)
     */
    private $salt;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $email;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $apiKey;

    /**
     * @var \DateTime
     * @MongoDB\Field(type="date", nullable=false)
     */
    private $creationDate;

    /**
     * @var array
     * @MongoDB\Field(type="collection")
     */
    private $roles;

    /**
     * @MongoDB\PrePersist()
     */
    public function setCreatedAt(){
        $this->creationDate = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt(): string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

}