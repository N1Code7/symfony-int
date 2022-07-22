<?php

namespace App\Controller\Front;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category_index')]
    public function index(BookRepository $repository1, CategoryRepository $repository2, int $id): Response
    {
        $books = $repository1->findAllBooksByCategoryId($id);
        $category = $repository2->findCategoryById($id);
        // die(var_dump($category));

        return $this->render('front/category/index.html.twig', [
            'books' => $books,
            "category" => $category
        ]);
    }
}
