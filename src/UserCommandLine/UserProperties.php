<?php

namespace HeavenProject\UserCommandLine;

use Doctrine\ORM\Mapping as ORM;

trait UserProperties
{
    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     *
     * @var string
     */
    public $username;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     *
     * @var string
     */
    public $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    public $password;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     *
     * @var string
     */
    public $salt;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    public $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    public $tokenCreatedAt;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    public $isAuthenticated = false;
}
