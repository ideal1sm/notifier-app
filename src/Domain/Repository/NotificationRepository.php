<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Notification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,

    ) {
        parent::__construct($registry, Notification::class);
    }

    public function save(Notification $notification, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->persist($notification);

        if ($flush) {
            $em->flush();
        }
    }

    public function remove(Notification $notification, bool $flush = true): void
    {
        $em = $this->getEntityManager();
        $em->remove($notification);

        if ($flush) {
            $em->flush();
        }
    }
}