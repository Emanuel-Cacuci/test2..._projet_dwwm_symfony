<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Form\AuteurType;
use App\Repository\AuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/auteur', name: 'admin.auteur.' )]
class AuteurController extends AbstractController
{
    #[Route(name: 'index')]
    public function index(AuteurRepository $auteurRepository)
    {
        return $this->render('admin/auteur/index.html.twig', [
            'auteurs' => $auteurRepository->findAll()
        ]);
    }

    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', 'slug' => '[a-z-0-9-]+'])]
    public function show(Request $request, string $slug, int $id, AuteurRepository $auteurRepository): Response
    {
        $auteur = $auteurRepository->find($id);

        if ($auteur->getSlug() !== $slug) {
            return $this->redirectToRoute('admin.auteur.show', ['slug' => $auteur->getSlug(), 'id' => $auteur->getId()] );
        }

        return $this->render('admin/auteur/show.html.twig', [
            'auteur' => $auteur
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($auteur);
            $em->flush();
            $this->addFlash('Success', "L'auteur a bien été crée");
            return $this->redirectToRoute('admin.auteur.index');

        }
        return $this->render('admin/auteur/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'Post'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Auteur $auteur, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('Success', "L'auteur a bien été modifiée");
            return $this->redirectToRoute('admin.auteur.index');
        }
        return $this->render('admin/auteur/edit.html.twig', [
            'auteur' => $auteur,
            'form' => $form
        ]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Auteur $auteur, EntityManagerInterface $em)
    {
        $em->remove($auteur);
        $em->flush();
        $this->addFlash('Success', "L'auteur a bien été supprimée");
        return $this->redirectToRoute('admin.auteur.index');
    }
}

?>