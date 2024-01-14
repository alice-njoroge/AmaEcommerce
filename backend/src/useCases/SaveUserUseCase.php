<?php

namespace App\useCases;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SaveUserUseCase
{
    private UserRepository $userRepository;
    private ValidatorInterface $validator;
    private UserPasswordHasherInterface $passwordHash;
    private MailerInterface $mailer;

    public function __construct(
        UserRepository              $userRepository,
        ValidatorInterface          $validator,
        UserPasswordHasherInterface $passwordHash,
        MailerInterface             $mailer
    )
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->passwordHash = $passwordHash;
        $this->mailer = $mailer;
    }


    /**
     * @throws NonUniqueResultException
     * @throws TransportExceptionInterface
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
        $this->userRepository->save($user);

        $email = new TemplatedEmail();
        $email->from('noreply@example.com');
        $email->to($user->getEmail());
        $email->subject('Welcome to our Pineapple Stand');
        $email->text('Thank you for signing up!');
        $email->htmlTemplate('emails/register.html.twig');
        $email->context([
            'emailAddress' => $user->getEmail(),
        ]);

        $this->mailer->send($email);

        return $user;

    }

}