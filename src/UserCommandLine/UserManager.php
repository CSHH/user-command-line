<?php

namespace HeavenProject\UserCommandLine;

use HeavenProject\Utils\UniqueGenerator;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Security\Passwords;

class UserManager
{
    /** @var EntityRepository */
    private $repository;

    /** @var EntityManager */
    private $em;

    /** @var UserEntityInterface */
    private $user;

    /**
     * @param EntityManager       $em
     * @param UserEntityInterface $user
     */
    public function __construct(EntityManager $em, UserEntityInterface $user)
    {
        $this->repository = $em->getRepository(get_class($user));

        $this->em = $em;
        $this->user = $user;
    }

    /**
     * @param  string                    $username
     * @param  string                    $email
     * @param  string                    $password
     * @throws \InvalidArgumentException
     * @return UserEntityInterface
     */
    public function createUser($username, $email, $password)
    {
        if ($username && $this->repository->findOneBy(array('username' => $username))) {
            throw new \InvalidArgumentException(sprintf("User with username '%s' already exists.", $username));
        }

        if ($email && $this->repository->findOneBy(array('email' => $email))) {
            throw new \InvalidArgumentException(sprintf("User with email '%s' already exists.", $email));
        }

        $this->user->setUsername($username);
        $this->user->setEmail($email);

        $salt = $this->generateSalt();

        $this->user->setPassword(Passwords::hash($password.$salt));
        $this->user->setSalt($salt);

        $this->user->setIsAuthenticated(true);

        $this->em->persist($this->user);
        $this->em->flush();

        return $this->user;
    }

    /**
     * @return string
     */
    public function generateSalt()
    {
        $saltsInUse = [];

        foreach ($this->repository->findAll() as $e) {
            $saltsInUse[] = $e->getSalt();
        }

        return UniqueGenerator::generate($saltsInUse, 10, '0-9A-Za-z');
    }
}
