<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @author Gloire Kafwalubi on 01/11/2022 - 12:14 AM
 * <gloirekaf.mwansha@gmail.com>
 *
 */
class CreateSuperAdminCommand extends Command
{
    protected static $defaultName = 'app:create-admin';
    private EntityManagerInterface $em;
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher)
    {
        parent::__construct(self::$defaultName);
        $this->em = $manager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @author Gloire Kafwalubi on 01/11/2022 - 12:15 AM
     * <gloirekaf.mwansha@gmail.com>
     */
    protected function configure()
    {
        $this
            ->setDescription('Create Admin')
            ->setHelp('This command allows you to create a user...')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'The User Email')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'The user password');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @author Gloire Kafwalubi on 01/11/2022 - 12:15 AM
     * <gloirekaf.mwansha@gmail.com>
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = User::createFromCommand($input->getOption('email'));
        $password = $this->userPasswordHasher->hashPassword($user, $input->getOption('password'));
        $user->setPassword($password);
        $this->em->persist($user);
        $this->em->flush();

        $io->success(sprintf('User %s Created', $input->getOption('email')));
        return 0;
    }
}
