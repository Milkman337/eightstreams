<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserService
{
    public function __construct(private readonly EntityManagerInterface         $entityManager,
                                private readonly PasswordHasherFactoryInterface $hasherFactory)
    {
    }

    public function persisAndFlushUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function setUserPassword(User $user, string $plainPassword): void
    {
        $user->setPassword(
            $this->hasherFactory->getPasswordHasher($user)->hash(
                $plainPassword
            )
        );
    }
}