<?php

namespace HeavenProject\Tests\UserCommandLine;

use Tester;
use Tester\Assert;
use Kdyby\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use HeavenProject\UserCommandLine\CreateUserCommand as Cmd;
use Mockery as m;

require __DIR__.'/../bootstrap.php';

class CreateUserCommandTest extends Tester\TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testCreateUserWithUsernameAndEmailAndPassword()
    {
        $userManager = m::mock('HeavenProject\UserCommandLine\UserManager')
            ->shouldReceive('createUser')
            ->once()
            ->getMock();

        $app = new Application();
        $app->add(new Cmd($userManager));

        $cmd = $app->find('hproj:create-user');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(array(
            '--' . Cmd::OPTION_USERNAME => 'johndoe',
            '--' . Cmd::OPTION_EMAIL    => 'john.doe@example.com',
            '--' . Cmd::OPTION_PASSWORD => 'secret',
        ));

        Assert::contains('User was successfully created.', $cmdTester->getDisplay());
    }

    public function testCreateUserWithUsernameAndPassword()
    {
        $userManager = m::mock('HeavenProject\UserCommandLine\UserManager')
            ->shouldReceive('createUser')
            ->once()
            ->getMock();

        $app = new Application();
        $app->add(new Cmd($userManager));

        $cmd = $app->find('hproj:create-user');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(array(
            '--' . Cmd::OPTION_USERNAME => 'johndoe',
            '--' . Cmd::OPTION_PASSWORD => 'secret',
        ));

        Assert::contains('User was successfully created.', $cmdTester->getDisplay());
    }

    public function testCreateUserWithEmailAndPassword()
    {
        $userManager = m::mock('HeavenProject\UserCommandLine\UserManager')
            ->shouldReceive('createUser')
            ->once()
            ->getMock();

        $app = new Application();
        $app->add(new Cmd($userManager));

        $cmd = $app->find('hproj:create-user');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(array(
            '--' . Cmd::OPTION_EMAIL    => 'john.doe@example.com',
            '--' . Cmd::OPTION_PASSWORD => 'secret',
        ));

        Assert::contains('User was successfully created.', $cmdTester->getDisplay());
    }

    public function testCreateUserWithoutUsernameOrEmail()
    {
        $userManager = m::mock('HeavenProject\UserCommandLine\UserManager')
            ->shouldReceive('createUser')
            ->never()
            ->getMock();

        $app = new Application();
        $app->add(new Cmd($userManager));

        $cmd = $app->find('hproj:create-user');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(array(
            '--' . Cmd::OPTION_PASSWORD => 'secret',
        ));

        Assert::contains('Either username or email must be set.', $cmdTester->getDisplay());
    }

    public function testCreateUserWithoutPassword()
    {
        $userManager = m::mock('HeavenProject\UserCommandLine\UserManager')
            ->shouldReceive('createUser')
            ->never()
            ->getMock();

        $app = new Application();
        $app->add(new Cmd($userManager));

        $cmd = $app->find('hproj:create-user');
        $cmdTester = new CommandTester($cmd);
        $cmdTester->execute(array(
            '--' . Cmd::OPTION_USERNAME => 'johndoe',
            '--' . Cmd::OPTION_EMAIL    => 'john.doe@example.com',
        ));

        Assert::contains('You forgot to set the password.', $cmdTester->getDisplay());
    }
}

$testCase = new CreateUserCommandTest();
$testCase->run();
