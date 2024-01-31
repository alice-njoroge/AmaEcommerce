<?php

namespace App\Command;

use App\Entity\Permission;
use App\Enum\RoleEnum;
use App\Repository\PermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-permissions',
    description: 'Add a short description for your command',
)]
class AddPermissionsCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(PermissionRepository $permissionRepository, EntityManagerInterface $entityManager)
    {
        $this->permissionRepository = $permissionRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $permissions = [
            RoleEnum::ROLE_ADD_USER->value => 'can add other users to the platform',
            RoleEnum::ROLE_ADD_PRODUCT->value => 'can add products to the platform',
            RoleEnum::ROLE_EDIT_PRODUCT->value => 'can edit products in the platform',
            RoleEnum::ROLE_DELETE_PRODUCT->value => 'can delete products from the platform',
        ];

        foreach ($permissions as $label => $description) {
            // find if permissions exist before creating them
            $permission = new Permission();

            $permission->setLabel($label);
            $permission->setDescription($description);

            $this->entityManager->persist($permission);
        }
        $this->entityManager->flush();

        $output->writeln('Permissions have been added successfully.');

        return Command::SUCCESS;
    }
}
