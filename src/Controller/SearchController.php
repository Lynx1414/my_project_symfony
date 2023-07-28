<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\References;
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
    public function index(ReferencesRepository $referencesRepository): Response
    {

        return $this->render('search/index.html.twig', [
            'references' => $referencesRepository->findAll(),
            
        ]);
    }

    #[Route('/{id}', name: 'app_search_byRef', methods:['GET'])]
    public function search(Request $request, ProduitsRepository $produitsRepository): Response
    {
        //! Récupérer la valeur de l'attribut 'id' depuis l'objet Request
        //! L'attribut $request->attributes est un objet de type AttributeBag, qui est essentiellement un conteneur de données associatives. Dans Symfony, les attributs sont utilisés pour stocker des informations supplémentaires sur une requête.
        $attribut= $request->attributes->get('id');
        
        //! Appeller la method findOneBy du repository et lui passer un array('champ de colonne FK sans _id ' => $variable qui stocke la valeur de l'attribut)
        $nomProduitRef= $produitsRepository->findOneBy(array('reference' => $attribut));
        //! return l'entity Produits 
        //retourner la vue
        return $this->render('search/findByRef.html.twig', array(
            "attribut" => $attribut,
            "nomProduitRef"=> $nomProduitRef,
        ));
    }
}
