<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Users;
use App\Form\ProduitsType;
use App\Form\SearchBarType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'app_produits_index', methods: ['GET', 'POST'])]
    public function index(PaginatorInterface $paginator, ProduitsRepository $produitsRepository, Request $request): Response
    {
        $produits= new Produits();
        $form_nom= $this->createForm(SearchBarType::class, $produits);
        $form_nom->handleRequest($request);
       
        $query= $produitsRepository->findAll();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        $resultat_search= [];
        
        if ($form_nom->isSubmitted() && $form_nom->isValid()) {
            $mot= $form_nom->get('nom_produit')->getData();
            
            $resultat_search= $produitsRepository->searchProduitByNom($mot);
            //dd($resultat_search);//renvoie un [];
            if(count($resultat_search) == 0){
                $resultat_search = "null";
            }
        }
        
        return $this->render('produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
            'produitVedette' => $produitsRepository->lastProduitVedette(),
            'form'=> $form_nom->createView(),
            'resultats'=> $resultat_search,
            'pagination'=> $pagination,
        ]);
    }
    //stock dans une variable une instance de l’entité Produits
    //créé le formulaire
    //le formulaire qui est inspecté via la méthode handleRequest()
    //créé un tableau vide qui va stocker les resultats
    //recupere récupère input. Value avec la méthode getData().     
    //getData() est stocké dans la variable $mot

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        //Recuperation des informations de l'utilisateur connecté(courant)
        $user = $this->getUser();
        // dd($user);
        //Pour creer un produits l'entité utilisateur courant (Mutateur = setter Utilisateurs)
        $produit->setUser($user);
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file= $form["image_produit"]->getData();
            //recupération de la propriété privée de l'image dans l'entité
            if(!is_string($file)){
                $fileName= $file->getClientOriginalName();
                $file->move(
                    $this->getParameter("images_directory"),
                    $fileName
                );
                $produit->setImageProduit($fileName);
                $this->addFlash('success', 'votre image a bien été ajoutée !');
            }else{
                $this->addFlash('error', 'Une erreur est survenue durant la création de l\'image');
                //redirection vers la page ajouter produit
                return $this->redirect($this->generateUrl('app_produits_new'));
            }

            //la requête DQL INSERT INTO
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        //recup de la photo courante avec le getter
        $img= $produit->getImageProduit();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //traitement du fichier upload
            $file= $form['image_produit']->getData();
            if(!is_string($file)){
                $fileName= $file->getClientOriginalName();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
                $produit->setImageProduit($fileName);
                $this->addFlash('success', 'Votre image a bien été modifiée !');
            }else{
                $produit->setImageProduit($img);
            }

            //DQL UPDATE ET SAUVEGARDE
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/tableauBordUser', name: 'app_produits_tableauBordUser', methods: ['GET', 'POST'])]
    public function displayTableauBordUser(Users $users): Response
    {
        $userProduits= $users->getProduits();
        return $this->render('produits/tableauBordUser.html.twig', [
            'userProduits' => $userProduits,
        ]);
    }


    
}




    // #[Route('/{id}/search', name: 'app_search', methods: ['GET', 'POST'])]
    // public function search(Request $request, References $references,  ReferencesRepository $referencesRepository, EntityManagerInterface $entityManager, $ref=null): Response
    // {
    //     // $reference = new References();
    //     // // Créez le formulaire
    //     // $form_ref = $this->createForm(SearchType::class, $reference);
    //     // // Traitez le formulaire
    //     // $form_ref->handleRequest($request);
    //     // // Vérifiez si le formulaire a été soumis et est valide
    //     // if ($form_ref->isSubmitted() && $form_ref->isValid()) {
    //     //     return $this->redirectToRoute('app_produits_search', [], Response::HTTP_SEE_OTHER);
    //     // }

    //     return $this->render('produits/searchReference.html.twig', [
    //         'references' => $referencesRepository->findAll()
    //     ]);
    // }

