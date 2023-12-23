<?php

namespace App\Repository;

use App\Entity\Facture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Facture>
 *
 * @method Facture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Facture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Facture[]    findAll()
 * @method Facture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Facture::class);
    }
    public function afficherFactures(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
        SELECT r.*,v.image as 'image',m.libelle as 'model',cat.libelle as 'categorie',c.nom as 'nomc',c.prenom as 'prenomc',a.nomagence as 'agence',TIMESTAMPDIFF(DAY, r.date_depart, r.date_retour) AS 'duree' , f.*
        FROM reservation r join client c on c.id = r.client_id
                    join voiture v on v.id = r.voiture_id
                   join categorie cat on cat.id = v.categorie_id
                   join model m on m.id = v.model_id
                   join agence a on a.id = r.agence_id
                   join facture f on r.id = f.reservation_id
            
            ";

        $resultSet = $conn->executeQuery($sql);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
//    /**
//     * @return Facture[] Returns an array of Facture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Facture
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
