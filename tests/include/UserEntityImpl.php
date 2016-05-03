<?php

namespace HeavenProject\Tests;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;
use HeavenProject\UserCommandLine\UserTrait;
use HeavenProject\UserCommandLine\UserEntityInterface;

/**
 * @ORM\Entity
 */
class UserEntityImpl implements UserEntityInterface
{
    use Identifier;
    use UserTrait;
}
