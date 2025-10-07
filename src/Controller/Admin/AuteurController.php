<?php

namespace App\Controller\Admin;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

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

    // #[Route('/show', name: 'show', requirements: [''] )]

}


?>