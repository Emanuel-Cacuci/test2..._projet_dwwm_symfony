<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/categorie', name: 'admin.categorie.' )]
class CategorieController extends AbstractController {

    #[Route(name: 'index')]
    public function index(CategorieRepository $categorieRepository)
    {
        return $this->render('admin/categorie/index.html.twig',[
            'categories' => $categorieRepository->findAll()
        ]);
    }

    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, CategorieRepository $categorieRepository): Response 
    {
        $categorie = $categorieRepository->find($id);

        if ($categorie->getSlug() !== $slug) {
            return $this->redirectToRoute('admin.categorie.show', ['slug' => $categorie->getSlug(), 'id' => $categorie->getId()]);
        }
        return $this->render('admin/categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isvalid()){
            $em->persist($categorie);
            $em->flush();
            $this->addflash('Success', 'La catégorie a bien été crée');
            return $this->redirectToroute('admin.categorie.index');
        }
        return $this->render('admin/categorie/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirements: ['id' => Requirement::DIGITS])]
    public function edit(Categorie $categorie, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('Success', 'La catégorie a bien été modifiée');
            return $this->redirectToRoute('admin.categorie.index');
        }
        return $this->render('admin/categorie/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Categorie $categorie, EntityManagerInterface $em)
    {
        $em->remove($categorie);
        $em->flush();
        $this->addFlash('Success', 'La catégorie a bien été supprimée');
        return $this->redirectToRoute('admin.categorie.index');
    }
}

?>