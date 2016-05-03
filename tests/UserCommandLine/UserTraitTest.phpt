<?php

namespace HeavenProject\Tests\UserCommandLine;

use HeavenProject\Tests\UserEntityImpl;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class UserTraitTest extends Tester\TestCase
{
    /** @var UserEntityImpl */
    private $user;

    protected function setUp()
    {
        $this->user = new UserEntityImpl;
    }

    public function testSetAndGetUsername()
    {
        Assert::null($this->user->getUsername());
        $this->user->setUsername('johndoe');
        Assert::same('johndoe', $this->user->getUsername());
    }

    public function testSetAndGetEmail()
    {
        Assert::null($this->user->getEmail());
        $this->user->setEmail('john.doe@example.com');
        Assert::same('john.doe@example.com', $this->user->getEmail());
    }

    public function testSetAndGetPassword()
    {
        Assert::null($this->user->getPassword());
        $this->user->setPassword('secret');
        Assert::same('secret', $this->user->getPassword());
    }

    public function testSetAndGetSalt()
    {
        Assert::null($this->user->getSalt());
        $this->user->setSalt('salt');
        Assert::same('salt', $this->user->getSalt());
    }

    public function testSetAndGetToken()
    {
        Assert::null($this->user->getToken());
        $this->user->setToken('token');
        Assert::same('token', $this->user->getToken());
    }

    public function testSetAndGetTokenCreatedAt()
    {
        Assert::null($this->user->getTokenCreatedAt());
        $x = new \DateTime;
        $this->user->setTokenCreatedAt($x);
        Assert::true($x instanceof \DateTime);
        Assert::equal($x, $this->user->getTokenCreatedAt());
    }

    public function testSetAndGetIsAuthenticated()
    {
        Assert::false($this->user->getIsAuthenticated());
        $this->user->setIsAuthenticated(true);
        Assert::true($this->user->getIsAuthenticated());
    }
}

$testCase = new UserTraitTest;
$testCase->run();
