<?php

namespace HeavenProject\UserCommandLine;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Create new user and save it in database.
 */
class CreateUserCommand extends Command
{
    /** @var string */
    const OPTION_USERNAME = 'username';
    /** @var string */
    const OPTION_USERNAME_SHORT = 'u';
    /** @var string */
    const OPTION_EMAIL = 'email';
    /** @var string */
    const OPTION_EMAIL_SHORT = 'e';
    /** @var string */
    const OPTION_PASSWORD = 'password';
    /** @var string */
    const OPTION_PASSWORD_SHORT = 'p';

    /** @var int */
    const EXIT_CODE_OK = 0;
    /** @var int */
    const EXIT_CODE_ERROR = 1;

    /** @var array */
    private $options = array(
        self::OPTION_USERNAME => null,
        self::OPTION_EMAIL => null,
        self::OPTION_PASSWORD => null,
    );

    /** @var UserManager */
    private $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        parent::__construct();

        $this->userManager = $userManager;
    }

    protected function configure()
    {
        $command = $this->setName('hproj:create-user');

        $command->setAliases(
            array('hproj:create:user')
        );

        $u = self::OPTION_USERNAME;
        $e = self::OPTION_EMAIL;
        $p = self::OPTION_PASSWORD;

        $help = <<<EOL
There are exactly three ways how the new user can be created:

1. Specify username and password:
   <info>hproj:create-user --{$u} johndoe --{$p} secret</info>

2. Specify email and password:
   <info>hproj:create-user --{$e} john.doe@example.com --{$p} secret</info>

3. Specify all username, email and password:
   <info>hproj:create-user --{$u} johndoe --{$e} john.doe@example.com --{$p} secret</info>

This means that password is allways required.
EOL;

        $command->setDescription('Create new user and save it in database');

        $command->setHelp($help);

        $this->setOptions($command);
    }

    /**
     * @param Command $command
     */
    private function setOptions(Command $command)
    {
        $command->addOption(
            self::OPTION_USERNAME,
            self::OPTION_USERNAME_SHORT,
            InputOption::VALUE_REQUIRED,
            'Set username'
        );

        $command->addOption(
            self::OPTION_EMAIL,
            self::OPTION_EMAIL_SHORT,
            InputOption::VALUE_REQUIRED,
            'Set email'
        );

        $command->addOption(
            self::OPTION_PASSWORD,
            self::OPTION_PASSWORD_SHORT,
            InputOption::VALUE_REQUIRED,
            'Set password'
        );
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->prepareOptions($input->getOptions());

            $this->userManager->createUser(
                $this->options[self::OPTION_USERNAME],
                $this->options[self::OPTION_EMAIL],
                $this->options[self::OPTION_PASSWORD]
            );

            $output->writeln(
                sprintf(PHP_EOL . '<info>User was successfully created.</info>')
            );

            return self::EXIT_CODE_OK;
        } catch (\Exception $e) {
            $output->writeln(
                sprintf(PHP_EOL . '<error>%s</error>', $e->getMessage())
            );

            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * @param  array                     $options
     * @throws \InvalidArgumentException
     */
    private function prepareOptions(array $options = array())
    {
        foreach ($options as $option => $value) {
            $this->options[$option] = $value;
        }

        if (!$this->options[self::OPTION_USERNAME] && !$this->options[self::OPTION_EMAIL]) {
            throw new \InvalidArgumentException(
                sprintf('Either %s or %s must be set.', self::OPTION_USERNAME, self::OPTION_EMAIL)
            );
        } elseif (!$this->options[self::OPTION_PASSWORD]) {
            throw new \InvalidArgumentException(
                sprintf('You forgot to set the %s.', self::OPTION_PASSWORD)
            );
        }
    }
}
