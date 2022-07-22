<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category')]
    public function index(CategoryRepository $repository, int $id): Response
    {
        $category = $repository->findCategorybyId($id);

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
