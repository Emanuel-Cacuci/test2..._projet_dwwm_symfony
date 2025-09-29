<?php

namespace App\Controller\Admin;

// use App\Entity\Auteur;
// use App\Entity\Categorie;
// use App\Entity\Produit;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpKernel\Exception\NearMissValueResolverException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route("/admin/produits", name: 'admin.produit.')]
final class ProduitController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $em): Response
    {

        $produits = $produitRepository->findByStock(25);

        // dd($produitRepository->findTotalStock());

        // $em->remove($produits[2]);
        // $em->flush();

        // $categorie = $em->getRepository(Categorie::class)->find(1);
        // $auteur = $em->getRepository(Auteur::class)->find(1);

        // $produit = new Produit();
        // $produit->setNom('Livre enfants')
        //     ->setSlug('livre-enfants')
        //     ->setDescription('Histoire de la bible pour enfants')
        //     ->setPrix(13)
        //     ->setStock(11)
        //     ->setImages(14356478);
        // $produit->setCategorie($categorie);
        // $produit->setAuteur($auteur);

        // $em->persist($produit);
        // $em->flush();

        // $produits[0]->setNom('Livre histoire');
        // $em->flush();
        // return new Response('Produit');
        return $this->render('produit/index.html.twig', [
            'produits' => $produits
        ]);
    }

    #[Route('/{slug}-{id}', name: 'show', requirements: ['id' => '\d+', 'slug' => '[a-z0-9-]+'])]
    public function show(Request $request, string $slug, int $id, ProduitRepository $produitRepository): Response
    {
        $produit = $produitRepository->find($id);
        //    dd($produit);

        if ($produit->getSlug() !== $slug) {
            return $this->redirectToRoute('produit.show', ['slug' => $produit->getSlug(), 'id' => $produit->getId()]);
        }
        return $this->render('produit/show.html.twig', [
            'produit' => $produit
        ]);

        // return $this->json([
        //     'slug' => $slug
        // ]);

        // return new Response('Produit : ' . $slug);
    }

    #[Route('/new', name: 'new')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($produit);
            $em->flush();
            $this->addFlash('Succes', 'Le produit à bien été crée');
            return $this->redirectToRoute('produit.index');
        }
        return $this->render('produit/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'], requirement: ['id' => Requirement::DIGITS])]
    public function edit(Produit $produit, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('Succes', 'Le produit à bien été modifiée');
            return $this->redirectToRoute('produit.index');
        }
        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form

        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'], requirement: ['id' => Requirement::DIGITS])]
    public function delete(Produit $produit, EntityManagerInterface $em)
    {
        $em->remove($produit);
        $em->flush();
        $this->addFlash('Succes', 'Le produit à bien été supprimée');
        return $this->redirectToRoute('produit.index');
    }
}
