# User Command Line

Manage users via Symfony Console and Doctrine ORM on command line.

## Installation

`composer require heavenproject/user-command-line`

## Requirements

- [Nette Framework](https://github.com/nette/nette)

## Documentation

In order for the `hproj:create-user` (or `hproj:create:user` as alias) command to work correctly
a small update in your application code is required.

Because we work with users here, there has to be some user entity in your application. This entity
must implement the `UserEntityInterface`. That´s all.

You have many options how to do this. You can implement the entire interface yourself if your need some custom logic
but this library contains some bits of pieces of code among which there are `UserMethods` and `UserProperties`
both of which are combined in one single `UserTrait`. These might help you with the implementation.

If you need more info on how to use the above command, use your Symfony Console
in your command line the way that you are used to (in Nette it is `php www/index.php`)
and type `help hproj:create-user` (eg: `php www/index.php help hproj:create-user`).

### Example 1

```
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use HeavenProject\UserCommandLine\UserTrait;
use HeavenProject\UserCommandLine\UserEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class UserEntity implements UserEntityInterface
{
    use UserTrait;
}
```

### Example 2

```
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use HeavenProject\UserCommandLine\UserMethods;
use HeavenProject\UserCommandLine\UserEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class UserEntity implements UserEntityInterface
{
    use UserMethods;

    // Your properties
}
```

### Example 3

```
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use HeavenProject\UserCommandLine\UserProperties;
use HeavenProject\UserCommandLine\UserEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class UserEntity implements UserEntityInterface
{
    use UserProperties;

    // Your methods
}
```

### Example 4

```
namespace App\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use HeavenProject\UserCommandLine\UserEntityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class UserEntity implements UserEntityInterface
{
    // Your entire own implementation of properties and methods
}
```

You can of course add more properties and methods in your entity if you wish.

## Config

Register the `UserCommandLineExtension` in your application neon config
and to this extension provide the `targetEntity` which is your updated user entity (class name together with namespace).

```
extensions:
    userCommandLine: HeavenProject\UserCommandLine\UserCommandLineExtension

userCommandLine:
    targetEntity: App\Model\Entities\UserEntity
```

## License

This source code is [free software](http://www.gnu.org/philosophy/free-sw.html)
available under the [MIT license](license.md).
