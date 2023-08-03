<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Enseignes;
use App\Repository\CategoriesRepository;
use App\Repository\EnseignesRepository;
use App\Repository\ProduitsRepository;
use App\Repository\ReferencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search_index', methods: ['GET', 'POST'])]
    public function index(ReferencesRepository $referencesRepository, CategoriesRepository $categoriesRepository, EnseignesRepository $enseignesRepository): Response
    {

        return $this->render('search/index.html.twig', [
            'references' => $referencesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'enseignes' => $enseignesRepository->findAll(),
            // todo
        ]);
    }

   
    #[Route('/{id}', name: 'app_search_byRef', methods:['GET'])]
    public function search(Request $request, ProduitsRepository $produitsRepository): Response
    {
        //! Récupérer la valeur de l'attribut 'id' depuis l'objet Request
        //! L'attribut $request->attributes est un objet de type AttributeBag, qui est essentiellement un conteneur de données associatives. Dans Symfony, les attributs sont utilisés pour stocker des informations supplémentaires sur une requête.
        $attribut= $request->attributes->get('id');
        
        //! Appeller la method findOneBy du repository et lui passer un array('champ de colonne FK sans _id ' => $variable qui stocke la valeur de l'attribut)
        $nomProduit= $produitsRepository->findOneBy(array('reference' => $attribut));
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByRef.html.twig', array(
            "attribut" => $attribut,
            "nomProduit"=> $nomProduit,
        ));
    }

    #[Route('/categorie/{id}', name: 'app_search_byCat', methods:['GET'])]
    public function searchCat(Categories $categories): Response
    {
        //! Appeller la method getProduits de l'entity Categories.php
        $nomsProduits= $categories->getProduits();
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByCat.html.twig', array(
            "categories" => $categories,
            "nomsProduits"=> $nomsProduits,
        ));
    }

     #[Route('/shop/{id}', name: 'app_search_by_shop', methods:['GET'])]
    public function searchEns(Enseignes $enseignes): Response
    {
        //! Appeller la method getProduits de l'entity Categories.php
        $nomsProduits= $enseignes->getProduits();
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByShop.html.twig', array(
            "enseignes" => $enseignes,
            "nomsProduits"=> $nomsProduits,
        ));
    }

    //stock dans une variable une instance de l’entité Produits
    //créé le formulaire
    //le formulaire qui est inspecté via la méthode handleRequest()
    //créé un tableau vide qui va stocker les resultats
    //recupere récupère input. Value avec la méthode getData().     
    //getData() est stocké dans la variable $mot

    

}
