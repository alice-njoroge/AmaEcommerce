<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:add-user',
    description: 'Add a short description for your command',
)]
class AddUserCommand extends Command
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;
    private UserPasswordHasherInterface $passwordHash;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        UserPasswordHasherInterface $passwordHash
    )
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->passwordHash = $passwordHash;
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userExists = $this->userRepository->findOneBy(['email' => 'admin@example.com']);

        if (!$userExists) {
            $user = new User();
            $user->setEmail('admin@example.com');
            $user->setPassword($this->passwordHash->hashPassword($user, 'admin123'));
            //find role admin and add it to this user
            $role = $this->roleRepository->findOneBy(['label' => 'ROLE_ADMIN']);
            $user->addRole($role);

            $this->userRepository->save($user);

            $output->writeln('User added successfully!');

        }
        return Command::SUCCESS;

    }
}
