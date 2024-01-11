<?php

namespace App\useCases;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveUserUseCase
{
    private UserRepository $userRepository;
    private ValidatorInterface $validator;
    private UserPasswordHasherInterface $passwordHash;

    public function __construct(UserRepository $userRepository, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHash)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->passwordHash = $passwordHash;
    }


    /**
     * @throws NonUniqueResultException
     */
    public function execute($data): User
    {
        //check if a user with a similar email exists
        $emailExists = $this->userRepository->findOneByEmail($data['email']);
        if ($emailExists) {
            throw new ValidatorException("Email already exists");
        }

        //set the data
        $user = new User();
        $user->setEmail($data['email']);
        //checking again if passwords match
        if ($data['password'] !== $data['confirmPassword']) {
            throw new ValidatorException("Passwords do not match");
        }
        //hash the passwords
        $user->setPassword($this->passwordHash->hashPassword($user, $data['password']));

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            throw new ValidatorException("you need to learn error handling and throwing exceptions in symfony");
        }

        return $this->userRepository->save($user);

    }

}