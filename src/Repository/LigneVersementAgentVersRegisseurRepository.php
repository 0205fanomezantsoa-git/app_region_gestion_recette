<?php

namespace App\Repository;

use App\Entity\LigneVersementAgentVersRegisseur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneVersementAgentVersRegisseur>
 */
class LigneVersementAgentVersRegisseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneVersementAgentVersRegisseur::class);
    }
    public function getTotalToday()
    {
    $start = new \DateTime('today');
    $end = new \DateTime('tomorrow');

    return $this->createQueryBuilder('v')
        ->select('SUM(v.montant)')
        ->where('v.date >= :start')
        ->andWhere('v.date < :end')
        ->setParameter('start', $start)
        ->setParameter('end', $end)
        ->getQuery()
        ->getSingleScalarResult() ?? 0;
    }

    public function getStatsLast7Days()
    {
        $result = $this->createQueryBuilder('v')
            ->select('v.date, v.montant')
            ->where('v.date >= :date')
            ->setParameter('date', new \DateTime('-7 days'))
            ->orderBy('v.date', 'ASC')
            ->getQuery()
            ->getResult();

        // 🔥 regroupement par jour (IMPORTANT)
        $data = [];

        foreach ($result as $row) {
            $date = $row['date']->format('Y-m-d');

            if (!isset($data[$date])) {
                $data[$date] = 0;
            }

            $data[$date] += $row['montant'];
        }

        // format final pour chart
        $final = [];
        foreach ($data as $date => $total) {
            $final[] = [
                'date' => $date,
                'total' => $total
            ];
        }

        return $final;
    }

    public function findJournalAgentRegisseur()
    {
        return $this->createQueryBuilder('v')
            ->select('v.id AS id, v.date AS date, v.typeVersement AS type, a.nom AS agent, r.nom AS regisseur, v.montant')
            ->join('v.agent', 'a')
            ->join('v.regisseur', 'r')
            ->orderBy('v.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getEtatAgents($start, $end)
    {
        return $this->createQueryBuilder('v')
            ->select('a.nom AS agent, l.nom AS localite, SUM(v.montant) AS total')
            ->join('v.agent', 'a')
            ->join('a.localite', 'l')
            ->where('v.date >= :start')
            ->andWhere('v.date < :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->groupBy('a.id')
            ->addGroupBy('l.id')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return LigneVersementAgentVersRegisseur[] Returns an array of LigneVersementAgentVersRegisseur objects
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

    //    public function findOneBySomeField($value): ?LigneVersementAgentVersRegisseur
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
