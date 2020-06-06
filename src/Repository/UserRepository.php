<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByCompany(Company $company, int $start = 0, int $limit = 5): Paginator
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.company = :company')
            ->setFirstResult($start)
            ->setMaxResults($limit)
            ->setParameters([
                'company' => $company
            ])
            ->getQuery();

        return new Paginator($query, $fetchJoinCollection = false);
    }
}
