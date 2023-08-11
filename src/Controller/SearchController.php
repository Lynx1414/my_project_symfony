<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Enseignes;
use App\Entity\Produits;
use App\Form\SearchBarType;
use App\Form\SelectCatType;
use App\Form\SelectRefType;
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
    public function index(ProduitsRepository $produitsRepository, Request $request, ReferencesRepository $referencesRepository, CategoriesRepository $categoriesRepository, EnseignesRepository $enseignesRepository): Response
    {
        $produits = new Produits();
        $form_nom = $this->createForm(SearchBarType::class, $produits);
        $form_nom->handleRequest($request);

        $form_ref = $this->createForm(SelectRefType::class, $produits);
        $form_ref->handleRequest($request);

        $form_cat = $this->createForm(SelectCatType::class, $produits);
        $form_cat->handleRequest($request);
        $resultat_search_cat = [];
        $resultat_search= [];


        if ($form_nom->isSubmitted() && $form_nom->isValid()) {
            $mot = $form_nom->get('nom_produit');
            // dd($mot);
            // dd($ref);// -viewData:"" -name:"" nom de colonne de produits de la key du form SearchBarType ex.// viewData:"3"
            // dd( $ref->getViewData());//retourne "3" l'id 
            // dd($ref->getName());// retourne "reference" nom de colonne et de la key du form SearchBarType
            $mot = $form_nom->get('nom_produit')->getData();
            // dd($form_nom->get('nom_produit')->getName());//nom du produit ex. ordinateur
            //todo = $mot= <input> $_POST['nom_produit'](key=>value)-> value
            $resultat_search = $produitsRepository->searchProduitByNom($mot);
            //dd($resultat_search);//renvoie un [];
            if (count($resultat_search) == 0) {
                $resultat_search = "null";
            }
        }

        if ($form_ref->isSubmitted() && $form_ref->isValid()) {
            $ref = $form_ref->get('reference');
            // dd($ref);// -viewData:"" -name:"" nom de colonne de produits de la key du form SearchBarType ex.// viewData:"3"
            // dd( $ref->getViewData());//retourne "3" l'id 
            // dd($ref->getName());// retourne "reference" nom de colonne et de la key du form SearchBarType
            $ref = $form_ref->get('reference')->getViewData();
            $resultat_search = [$produitsRepository->findOneBy(array('reference' => $ref))];
            // dd($resultat_search);
        }

        

        if ($form_cat->isSubmitted() && $form_cat->isValid()) {
            $cat = $form_cat->get('category');
            // dd($cat);//
            // dd($cat->getViewData());
            $cat = $form_cat->get('category')->getViewData();
            $resultat_search= $produitsRepository->searchProduitByCat($cat);
            // dd($resultat_search);
        }

        return $this->render('search/index.html.twig', [
            'references' => $referencesRepository->findAll(),
            'categories' => $categoriesRepository->findAll(),
            'enseignes' => $enseignesRepository->findAll(),
            'form' => $form_nom->createView(),
            'form_ref' => $form_ref->createView(),
            'form_cat' => $form_cat->createView(),
            'resultats' => $resultat_search,
           ]);
    }

    #[Route('/{id}', name: 'app_search_byRef', methods: ['GET'])]
    public function search(Request $request, ProduitsRepository $produitsRepository): Response
    {
        //! Récupérer la valeur de l'attribut 'id' depuis l'objet Request
        //! L'attribut $request->attributes est un objet de type AttributeBag, qui est essentiellement un conteneur de données associatives. Dans Symfony, les attributs sont utilisés pour stocker des informations supplémentaires sur une requête.
        $attribut = $request->attributes->get('id');

        //! Appeller la method findOneBy du repository et lui passer un array('champ de colonne FK sans _id ' => $variable qui stocke la valeur de l'attribut)
        $nomProduit = $produitsRepository->findOneBy(array('reference' => $attribut));
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByRef.html.twig', array(
            "attribut" => $attribut,
            "nomProduit" => $nomProduit,
        ));
    }

    #[Route('/categorie/{id}', name: 'app_search_byCat', methods: ['GET'])]
    public function searchCat(Categories $categories): Response
    {
        //! Appeller la method getProduits de l'entity Categories.php
        $nomsProduits = $categories->getProduits();
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByCat.html.twig', array(
            "categories" => $categories,
            "nomsProduits" => $nomsProduits,
        ));
    }

    #[Route('/shop/{id}', name: 'app_search_by_shop', methods: ['GET'])]
    public function searchEns(Enseignes $enseignes): Response
    {
        //! Appeller la method getProduits de l'entity Categories.php
        $nomsProduits = $enseignes->getProduits();
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByShop.html.twig', array(
            "enseignes" => $enseignes,
            "nomsProduits" => $nomsProduits,
        ));
    }

    //stock dans une variable une instance de l’entité Produits
    //créé le formulaire
    //le formulaire qui est inspecté via la méthode handleRequest()
    //créé un tableau vide qui va stocker les resultats
    //recupere récupère input. Value avec la méthode getData().     
    //getData() est stocké dans la variable $mot



}
