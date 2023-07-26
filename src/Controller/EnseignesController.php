<?php

namespace App\Controller;

use App\Entity\Enseignes;
use App\Form\EnseignesType;
use App\Repository\EnseignesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/enseignes')]
class EnseignesController extends AbstractController
{
    #[Route('/', name: 'app_enseignes_index', methods: ['GET'])]
    public function index(EnseignesRepository $enseignesRepository): Response
    {
        return $this->render('enseignes/index.html.twig', [
            'enseignes' => $enseignesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_enseignes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enseigne = new Enseignes();
        $form = $this->createForm(EnseignesType::class, $enseigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($enseigne);
            $entityManager->flush();

            return $this->redirectToRoute('app_enseignes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enseignes/new.html.twig', [
            'enseigne' => $enseigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enseignes_show', methods: ['GET'])]
    public function show(Enseignes $enseigne): Response
    {
        return $this->render('enseignes/show.html.twig', [
            'enseigne' => $enseigne,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enseignes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enseignes $enseigne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnseignesType::class, $enseigne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_enseignes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enseignes/edit.html.twig', [
            'enseigne' => $enseigne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enseignes_delete', methods: ['POST'])]
    public function delete(Request $request, Enseignes $enseigne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseigne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($enseigne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enseignes_index', [], Response::HTTP_SEE_OTHER);
    }
}
