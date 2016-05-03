<?php

namespace HeavenProject\Tests\UserCommandLine;

use HeavenProject\UserCommandLine\UserManager;
use HeavenProject\Tests\UserEntityImpl;
use HeavenProject\Utils\UniqueGenerator;
use Mockery as m;
use Tester;
use Tester\Assert;

require __DIR__.'/../bootstrap.php';

class UserManagerTest extends Tester\TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testThatGeneratedSaltIsUnique()
    {
        $saltsInUse = array();
        $callTimes  = 100;

        for ($i = 0; $i < ($callTimes * 5); $i++) {
            $saltsInUse[] = UniqueGenerator::generate($saltsInUse, 10, '0-9A-Za-z');
        }

        $userEntities = array();

        for ($i = 0; $i < 10; $i++) {
            $userEntities[] = m::mock('HeavenProject\UserCommandLine\UserEntityInterface')
                ->shouldReceive('getSalt')
                ->times($callTimes)
                ->andReturn($saltsInUse[$i])
                ->getMock();
        }

        $entityRepository = m::mock('Kdyby\Doctrine\EntityRepository')
            ->shouldReceive('findAll')
            ->times($callTimes)
            ->andReturn($userEntities)
            ->getMock();

        $em = m::mock('Kdyby\Doctrine\EntityManager')
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($entityRepository)
            ->getMock();

        $user        = new UserEntityImpl;
        $userManager = new UserManager($em, $user);

        for ($i = 0; $i < $callTimes; $i++) {
            Assert::true(!in_array($userManager->generateSalt(), $saltsInUse));
        }
    }

    public function testCreateUser()
    {
        $user = new UserEntityImpl;

        $entityRepository = m::mock('Kdyby\Doctrine\EntityRepository');
        $entityRepository->shouldReceive('findAll')
            ->once()
            ->andReturn(array());
        $entityRepository->shouldReceive('findOneBy')
            ->twice()
            ->andReturnNull();

        $em = m::mock('Kdyby\Doctrine\EntityManager');
        $em->shouldReceive('getRepository')
            ->once()
            ->andReturn($entityRepository);
        $em->shouldReceive('persist')
            ->once()
            ->andReturnSelf();
        $em->shouldReceive('flush')
            ->once()
            ->andReturnSelf();

        $userManager = new UserManager($em, $user);
        $ent         = $userManager->createUser('johndoe', 'john.doe@example.com', 'secret');

        Assert::same('johndoe', $ent->username);
        Assert::same('john.doe@example.com', $ent->email);
    }

    public function testCreateUserWithExistingUsernameThrowsException()
    {
        $user = new UserEntityImpl;

        $entityRepository = m::mock('Kdyby\Doctrine\EntityRepository');
        $entityRepository->shouldReceive('findOneBy')
            ->once()
            ->andReturn($user);

        $em = m::mock('Kdyby\Doctrine\EntityManager');
        $em->shouldReceive('getRepository')
            ->once()
            ->andReturn($entityRepository);

        $userManager = new UserManager($em, $user);

        Assert::exception(function () use ($userManager) {
            $userManager->createUser('johndoe', 'john.doe@example.com', 'secret');
        }, 'InvalidArgumentException', "User with username 'johndoe' already exists.");
    }

    public function testCreateUserWithExistingEmailThrowsException()
    {
        $user = new UserEntityImpl;

        $entityRepository = m::mock('Kdyby\Doctrine\EntityRepository');
        $entityRepository->shouldReceive('findOneBy')
            ->once()
            ->andReturnNull();
        $entityRepository->shouldReceive('findOneBy')
            ->once()
            ->andReturn($user);

        $em = m::mock('Kdyby\Doctrine\EntityManager');
        $em->shouldReceive('getRepository')
            ->once()
            ->andReturn($entityRepository);

        $userManager = new UserManager($em, $user);

        Assert::exception(function () use ($userManager) {
            $userManager->createUser('johndoe', 'john.doe@example.com', 'secret');
        }, 'InvalidArgumentException', "User with email 'john.doe@example.com' already exists.");
    }
}

$testCase = new UserManagerTest();
$testCase->run();
