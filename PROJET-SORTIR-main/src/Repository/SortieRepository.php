<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    /**
     * @var Security
     */
    private $security;


    public function __construct(ManagerRegistry $registry,Security $security)
    {
        parent::__construct($registry, Sortie::class);
        $this->security = $security;
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllOrderedBySites(): array
    {
        return $this->createQueryBuilder('s')
            ->addOrderBy('s.campus','ASC')
            ->getQuery()
            ->getResult();
    }
    public function findFiltered(EtatRepository $etatRepository, mixed $filters)
    {   $qb = $this->createQueryBuilder('s');
        if($filters['site']  != null){
            $qb->andWhere('s.campus = :campus')
                ->setParameter('campus', $filters['site']);
        }
        if($filters['textSearch'] != null){
            $qb->andWhere('s.nom = :nom')
                ->setParameter('nom', "%{$filters['textSearch']}%");
        }
        if($filters['startDate'] != null){
            $qb->andWhere('s.dateHeureDebut = :startDate')
                ->setParameter('startDate', $filters['startDate']);
        }
        if($filters['endDate']!= null){
            $qb->andWhere('s.dateHeureDebut = :endDate')
                ->setParameter('endDate', $filters['endDate']);
        }
        if($filters['organizer']){
            $qb->andWhere('s.organisateur = :organizer')
                ->setParameter('organizer', $this->security->getUser() );
        }
        if($filters['registered']){
            $qb->andWhere(':registered MEMBER OF s.participants')
                ->setParameter('registered', $this->security->getUser() );
        }
        if($filters['unregistered']){
            $qb->andWhere(':unregistered NOT MEMBER OF s.participants')
                ->setParameter('unregistered', $this->security->getUser() );
        }
        if($filters['ended']){
            $qb->andWhere('s.etat = :ended')
                ->setParameter('ended', $etatRepository->findOneBy(['Passée'])  );
        }


        return $qb->getQuery();
    }

//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}
