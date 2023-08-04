<?php
// namespace App\Service;

// use App\Entity\Produits;
// use App\Form\SearchBarType;
// use App\Repository\ProduitsRepository;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;

// class ResearchByNameService extends AbstractController {

//     private $produits;
//     private $request;
//     private $produitsRepository;

//     public function __construct(ProduitsRepository $produitsRepository, Request $request, AbstractController $abstractController, Produits $produits)
//     {
//         $this->produitsRepository = $produitsRepository;
//         $this->produits = $produits;
//         $this->request = $request;
        
//     }

//     public function searchByMot($mot) {
//         $form_nom= $this->createForm(SearchBarType::class, $this->produits);
//         $form_nom->handleRequest($this->request);
//         $resultat_search= [];
//         $resultat_search = $this->produitsRepository->searchProduitByNom($mot);

//         if ($form_nom->isSubmitted() && $form_nom->isValid()) {
//             $mot= $form_nom->get('nom_produit')->getData();
            
//             $resultat_search= $this->produitsRepository->searchProduitByNom($mot);
//             //dd($resultat_search);//renvoie un [];
//             if(count($resultat_search) == 0){
//                 $resultat_search = "null";
//             }
//         }

//         return $resultat_search;
//     }

//     //1. Créez le fichier ResearchByNameService.php dans le répertoire src/Service de votre projet Symfony.

//     //2. Définissez la classe ResearchByNameService dans le fichier ResearchByNameService.php et assurez-vous qu'elle est correctement configurée avec ses dépendances nécessaires (par exemple, le repository ProduitsRepository).
    
//     //3. Dans votre fichier services.yaml (généralement situé dans config/services.yaml), ajoutez une entrée pour déclarer le service ResearchByNameService :
// }

?>