<?php

namespace App\Command;

use App\Entity\Permission;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-role',
    description: 'Seeding Roles in a way that they can be added in a production environment',
    aliases: ['app:create-role']
)]
class CreateRoleCommand extends Command
{
    private EntityManagerInterface $em;
    private RoleRepository $roleRepository;

    public function __construct(EntityManagerInterface $em, RoleRepository $roleRepository)
    {
        $this->em = $em;
        $this->roleRepository = $roleRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $roles = [
            [
                'name' => 'ROLE_ADMIN',
                'description' => 'An admin role will have all system permissions',
            ],
            [
                'name' => 'ROLE_USER',
                'description' => 'A user will only shop, see own products and checkout',
            ],
        ];

        for ($i = 0; $i < count($roles); ++$i) {
            $label = $roles[$i]['name'];
            $role = $this->roleRepository->findOneBy(['label' => $label]);

            if (null === $role) {
                $role = new Role();
                $role->setLabel($label);
                $role->setDescription($roles[$i]['description']);
                $this->em->persist($role);
            }
            // give all the permissions to role admin
            if ('ROLE_ADMIN' === $role->getLabel()) {
                $permissions = $this->em->getRepository(Permission::class)->findAll();
                foreach ($permissions as $permission) {
                    $role->addPermission($permission);
                }
                $this->em->persist($role);
            }
        }

        $this->em->flush();
        $output->writeln('Roles Added Successfully :)');

        return Command::SUCCESS;
    }
}
