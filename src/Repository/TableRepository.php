<?php

namespace App\Repository;

use App\Entity\Table;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\VarExporter\Internal\Hydrator;

/**
 * @extends ServiceEntityRepository<Table>
 *
 * @method Table|null find($id, $lockMode = null, $lockVersion = null)
 * @method Table|null findOneBy(array $criteria, array $orderBy = null)
 * @method Table[]    findAll()
 * @method Table[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Table::class);
    }

    public function add(Table $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Table $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Renvoit le tableau des tables non réservées pour cette date ou dont la résa est annulée
     * @param \DateTime $dateEtHeure
     * @return float|int|mixed|string
     */
    public function listeTablesDispoParNbCouvertsCroissant (\DateTime $dateDebut, \DateTime $dateFin){

        // Récupère ttes les tables non réservées pour cette date OU dt résa est annulée
        $dql = "SELECT  t 
                FROM    App:Table t 
                        LEFT JOIN t.reservations r 
                WHERE   (r.etat='ANNULE' AND r.dateEtHeureArrivee BETWEEN :DEBUT AND :FIN) 
                        OR r IS NULL
                ORDER BY t.nbPlaces";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter("DEBUT", $dateDebut);
        $query->setParameter("FIN", $dateFin);

        return $query->getResult();
    }

//    /**
//     * @return Table[] Returns an array of Table objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Table
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
