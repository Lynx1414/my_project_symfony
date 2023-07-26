<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
use App\Form\ClientType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/clients')]
class ClientsController extends AbstractController
{
    #[Route('/', name: 'app_clients')]
    public function index(): Response
    {
        return $this->render('clients/index.html.twig', [
            'controller_name' => 'ClientsController',
        ]);
    }
    
    #[Route('/all', name: 'app_clients_all', methods:['GET'])]
    public function displayAll(ClientsRepository $clientsRepository): Response
    //! injection de dépendances :abstraction de la classe ClientsRepository en la stockant dans une variable
    {
        return $this->render('clients/clients.html.twig', [
          'clients' => $clientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_clients_new', methods:['GET','POST'])]
    public function addClient(Request $request, EntityManagerInterface $entityManagerInterface ): Response
    //! injection de dépendances :abstraction de la class Request pour prototypage de HEADER du BODY... ($_SERVER, $_SESSION, $_GET, $_POST, $_FILE...) équivalent encodeJson? et de la class EntityManagerInterface (dossier orm -> dossier lib\Doctrine\ORM-> fichier EntityManagerInterfac) pour accès aux méthodes de prototypage pour UPDATE et DELETE 
    {
        $newClient= new Clients();
        // todo Instance de la classe Produit Entity
        $form= $this->createForm(ClientsType::class, $newClient);
        // todo methode createForm qui SERT A LIER un form à une entité. Prend comme parametre la class du formulaire et l'entity créée ligne 49
        $form->handleRequest($request);
        // todo methode handleRequest() prototypé dans la class Request, récupère tous les champs du formaulaire
        //todo handleRequest($request) == $_POST['tous les attributs name des inputs']

        if($form->isSubmitted() && $form->isValid()){
            //todo isSubmitted == isset() en php isValid() == !empty() en php
            $entityManagerInterface->persist($newClient);
            //todo persist($nom de la table/entité) insert les données dans l'entité $client (=new Client)
            $entityManagerInterface->flush();
            //todo execute l'insertion, met à jour les datas

            return $this->redirectToRoute('app_client_all', array(), Response::HTTP_SEE_OTHER);
        }
        return $this->render('clients/new.html.twig', [
            'client' => $newClient,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_clients_show', methods:['GET'])]
    //!{id} équivaut à $_GET['id'] en PHP
    public function show(Clients $client): Response
    //! injection de dépendances :abstraction de la classe Clients (Entity) et la stocker dans variable pour avoir accès ici (sur le controller) à methode getId() de la classe CLients
    {
        return $this->render('clients/show.html.twig', [
            'client' => $client,
        ]);
        
    }

    #[Route('/{id}/edit', name: 'app_clients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clients $client, EntityManagerInterface $entityManagerInterface):Response
    {
        $form= $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_clients_all', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('clients/edit.html.twig', [
            'client'=>$client,
            'form'=>$form,
        ]);
    }

    #[Route('/{id}', name: 'app_clients_delete', methods: ['POST'])]
    public function delete(Request $request, Clients $client, EntityManagerInterface $entityManagerInterface):Response
    {
        if($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))){
            $entityManagerInterface->remove($client);
            $entityManagerInterface->flush();
        }
        return $this->redirectToRoute('app_clients_all', [], Response::HTTP_SEE_OTHER);
    }

}
