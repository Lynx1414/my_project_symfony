<?php

namespace App\Repository;

use App\Entity\References;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<References>
 *
 * @method References|null find($id, $lockMode = null, $lockVersion = null)
 * @method References|null findOneBy(array $criteria, array $orderBy = null)
 * @method References[]    findAll()
 * @method References[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferencesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, References::class);
    }

    public function findProduitByRef(){
        {
            $query = $this->createQueryBuilder('p')
                ->select('p.nom_produit') // Sélectionne uniquement le nom_produit
                ->join('p.reference', 'r') // Jointure avec la relation 'reference' (assumant que la relation est correctement configurée dans l'entité Produits)
                ->getQuery();
    
            $produits = $query->getResult();
    
            return $produits;
        }
    }
   
//    /**
//     * @return References[] Returns an array of References objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?References
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
