<?php

namespace HeavenProject\UserCommandLine;

interface UserEntityInterface
{
    /**
     * @param string $username
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $password
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $salt
     */
    public function setSalt($salt);

    /**
     * @return string
     */
    public function getSalt();

    /**
     * @param string $token
     */
    public function setToken($token);

    /**
     * @return string
     */
    public function getToken();

    /**
     * @param \DateTime $tokenCreatedAt
     */
    public function setTokenCreatedAt(\DateTime $tokenCreatedAt);

    /**
     * @return \DateTime
     */
    public function getTokenCreatedAt();

    /**
     * @param bool $isAuthenticated
     */
    public function setIsAuthenticated($isAuthenticated);

    /**
     * @return bool
     */
    public function getIsAuthenticated();
}
