<?php

namespace HeavenProject\Tests\UserCommandLine;

use Nette\Configurator;
use Nette\DI;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

class UserCommandLineExtensionTest extends Tester\TestCase
{
    /**
     * @param  string       $otherConfig
     * @return DI\Container
     */
    private function createContainer($otherConfig)
    {
        $tmpDir = __DIR__ . '/../tmp/' . getmypid();
        @mkdir($tmpDir, 0777);

        $config = new Configurator;
        $config->setTempDirectory($tmpDir);
        $config->addConfig(__DIR__ . '/../config/config.neon');
        $config->addConfig($otherConfig);

        return $config->createContainer();
    }

    public function testGeneratedContainer()
    {
        $container = $this->createContainer(__DIR__ . '/../config/extension.neon');
        $type      = 'HeavenProject\UserCommandLine\UserManager';

        Assert::type($type, $container->getByType($type));
    }

    public function testGeneratedContainerThrowsTargetEntityNotFoundException()
    {
        Assert::exception(function () {
            $this->createContainer(__DIR__ . '/../config/extension-not-found.neon');
        }, 'HeavenProject\UserCommandLine\TargetEntityNotFoundException', "Entity class 'HeavenProject\Tests\__Xyz__' was not found.");
    }

    public function testGeneratedContainerThrowsTargetEntityNotSetException()
    {
        Assert::exception(function () {
            $this->createContainer(__DIR__ . '/../config/extension-not-set.neon');
        }, 'HeavenProject\UserCommandLine\TargetEntityNotSetException', 'Target entity for UserCommandLineExtension was not set.');
    }
}

$testCase = new UserCommandLineExtensionTest;
$testCase->run();
