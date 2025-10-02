<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('admin/categorie', name: 'admin.categorie.' )]
class CategorieController extends AbstractController {

    #[Route(name: 'index')]
    public function index()
    {

    }

    #[Route('/new', name: 'new')]
    public function new()
    {

   
    }

    #[Route('/{id}', name: 'editer', requirements: ['id' => Requirement::DIGITS])]
    public function editer()
    {

    }

    #[Route('/{id}', name: 'delete', requirements: ['id' => Requirement::DIGITS])]
    public function delete()
    {

    }
}

?>