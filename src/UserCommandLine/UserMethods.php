<?php

namespace HeavenProject\UserCommandLine;

trait UserMethods
{
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param \DateTime $tokenCreatedAt
     */
    public function setTokenCreatedAt(\DateTime $tokenCreatedAt)
    {
        $this->tokenCreatedAt = $tokenCreatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getTokenCreatedAt()
    {
        return $this->tokenCreatedAt;
    }

    /**
     * @param bool $isAuthenticated
     */
    public function setIsAuthenticated($isAuthenticated)
    {
        $this->isAuthenticated = $isAuthenticated;
    }

    /**
     * @return bool
     */
    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }
}
