<?php

namespace App\Repository;

use App\Entity\LigneVersementRegisseurVersTresor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneVersementRegisseurVersTresor>
 */
class LigneVersementRegisseurVersTresorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneVersementRegisseurVersTresor::class);
    }

    public function getTotalToday()
    {
    $start = new \DateTime('today');      // 00:00:00
    $end = new \DateTime('tomorrow');     // 00:00:00 du lendemain

    return $this->createQueryBuilder('v')
        ->select('COALESCE(SUM(v.montant), 0)')
        ->where('v.date >= :start')
        ->andWhere('v.date < :end')
        ->setParameter('start', $start)
        ->setParameter('end', $end)
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function getTopRegisseursFiltered($start, $end, $search = null)
    {
        $qb = $this->createQueryBuilder('v')
            ->select('r.nom as regisseur, SUM(v.montant) as total')
            ->join('v.regisseur', 'r')
            ->where('v.date >= :start')
            ->andWhere('v.date < :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->groupBy('r.id')
            ->orderBy('total', 'DESC');

        if ($search) {
            $qb->andWhere('r.nom LIKE :search')
            ->setParameter('search', '%' . $search . '%');
        }

        return $qb->getQuery()->getResult();
    }

    public function findJournalRegisseurTresor()
    {
    return $this->createQueryBuilder('v')
        ->select('v.id AS id, v.date AS date, r.nom AS regisseur, t.nom AS tresor, v.montant')
        ->join('v.regisseur', 'r')
        ->join('v.tresor', 't')
        ->orderBy('v.date', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function getEtatRegisseurs($start, $end)
    {
    return $this->createQueryBuilder('v')
        ->select('r.nom AS regisseur, SUM(v.montant) AS total')
        ->join('v.regisseur', 'r')
        ->where('v.date >= :start')
        ->andWhere('v.date < :end')
        ->setParameter('start', $start)
        ->setParameter('end', $end)
        ->groupBy('r.id')
        ->orderBy('total', 'DESC')
        ->getQuery()
        ->getResult();
    }
    //    /**
    //     * @return LigneVersementRegisseurVersTresor[] Returns an array of LigneVersementRegisseurVersTresor objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LigneVersementRegisseurVersTresor
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
