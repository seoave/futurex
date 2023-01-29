<?php

namespace App\Repository;

use App\Entity\Currency;
use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wallet>
 *
 * @method Wallet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wallet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wallet[]    findAll()
 * @method Wallet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WalletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wallet::class);
    }

    public function save(Wallet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function saveMany(array $wallets):void
    {
        foreach ($wallets as $wallet) {
            $this->getEntityManager()->persist($wallet);
        }

        $this->getEntityManager()->flush();
    }

    public function remove(Wallet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findWalletByCurrency(User $user, Currency $currency): ?Wallet
    {
        return $this->getEntityManager()->getRepository(Wallet::class)->findOneBy([
            'owner' => $user,
            'currency' => $currency,
        ]);
    }

    public function findAllUserFunds(int $userId, bool $isToken = false)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT w.amount, c.code, c.name
                 FROM App\Entity\Wallet w
                 JOIN w.currency c
                 WHERE w.owner = :userId AND c.token = :isToken'
        )->setParameter('userId', $userId)
            ->setParameter('isToken', $isToken);

        return $query->getResult();
    }

//    /**
//     * @return Wallet[] Returns an array of Wallet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Wallet
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
