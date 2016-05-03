<?php

namespace HeavenProject\UserCommandLine;

use Kdyby\Console\DI\ConsoleExtension;
use Nette\DI\CompilerExtension;

class UserCommandLineExtension extends CompilerExtension
{
    /** @var array */
    private $defaults = array('targetEntity' => null);

    /**
     * @throws TargetEntityNotSetException
     * @throws TargetEntityNotFoundException
     */
    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);

        $entityClass = $config['targetEntity'];
        if (!$entityClass) {
            throw new TargetEntityNotSetException('Target entity for UserCommandLineExtension was not set.');
        } elseif (!class_exists($entityClass)) {
            throw new TargetEntityNotFoundException(sprintf("Entity class '%s' was not found.", $entityClass));
        }

        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('userManager'))
            ->setClass(
                'HeavenProject\UserCommandLine\UserManager',
                array(
                    '@doctrine.default.entityManager',
                    new $entityClass(),
                )
            );

        $builder->addDefinition($this->prefix('createUserCommand'))
            ->addTag(ConsoleExtension::COMMAND_TAG)
            ->setInject(false)
            ->setClass('HeavenProject\UserCommandLine\CreateUserCommand');
    }
}
