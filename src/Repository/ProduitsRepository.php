<?php

namespace App\Repository;

use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produits>
 *
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    public function lastProduitVedette(){
        $produitVedette= $this->createQueryBuilder('produitsCopy')
        ->orderBy('produitsCopy.id', 'DESC')
        ->setMaxResults(1)
        ->getQuery() 
        ->getOneOrNullResult();
        
        return $produitVedette;
    }

    
    // public function findProduitByRef($ref)
    // {
    //     $produitByRef = $this->createQueryBuilder('produitsCopy') // Crée un QueryBuilder pour l'entité Produits avec un alias 'produitsCopy'.
    //         ->join('produitsCopy.reference', 'referencesCopy') // Effectue une jointure entre l'entité Produits et l'entité Reference (via la relation reference_id) avec un alias 'referencesCopy'.
    //         ->where('referencesCopy.id', $ref) // Filtre les résultats en utilisant la clause WHERE pour récupérer uniquement les produits dont la référence (l'attribut id de l'entité Reference) correspond à la valeur $ref passée en paramètre.
    //         ->getQuery() // Obtient l'objet Query correspondant à la requête DQL construite.
    //         ->getResult(); // Exécute la requête et récupère le résultat sous forme d'un tableau d'objets.
    
    //     return $produitByRef; // Renvoie les produits trouvés sous forme d'un tableau d'objets.
    // }

//    /**
//     * @return Produits[] Returns an array of Produits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Produits
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}
