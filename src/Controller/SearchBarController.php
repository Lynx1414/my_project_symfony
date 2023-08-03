<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchBarController extends AbstractController
{
    // #[Route('/nom', name: 'app_search_index', methods: ['GET', 'POST'])]
    
    // public function index(Produits $produits, Request $request, ProduitsRepository $produitsRepository): Response
    // {
    //     //stock dans une variable une instance de l’entité Produits
    //     $produits= new Produits();
    //     //créé le formulaire
    //     $form_nom= $this->createForm(SearchBarType::class, $produits);
    //     //le formulaire qui est inspecté via la méthode handleRequest()
    //     $form_nom->handleRequest($request);
    //     //créé un tableau vide qui va stocker les resultats
    //     $resultat_search= [];
    //     //soumission du formulaire
    //     if ($form_nom->isSubmitted() && $form_nom->isValid()) {
    //         //recupere récupère input. Value avec la méthode getData().
    //         $mot= $form_nom->get('nom_produit')->getData();
    //        //getData() est stocké dans la variable $mot
    //        $resultat_search= $produitsRepository->searchProduitByNom($mot);
    //         //dd($resultat_search);//renvoie un [];
    //         if(count($resultat_search) == 0){
    //             $resultat_search = "null";
    //         }
    //     }

    //     return $this->render('search/index.html.twig', [
    //         'form_nom'=> $form_nom->createView(),
    //         'resultats'=> $resultat_search,
    //     ]);
    // }
}
