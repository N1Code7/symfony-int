<?php

namespace App\Controller\Front;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'app_category_showAllBooksOfOneCategory')]
    public function showAllBooksOfOneCategory(BookRepository $repository1, CategoryRepository $repository2, int $id): Response
    {
        $books = $repository1->findAllBooksByCategoryId($id);
        $category = $repository2->findCategoryById($id);

        return $this->render('front/category/showAllBooksOfOneCategory.html.twig', [
            'books' => $books,
            "category" => $category
        ]);
    }

    #[Route("/categories", name: "app_category_showAllCategories")]
    public function showAllCategories(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render("front/category/showAllCategories.html.twig", ["categories" => $categories]);
    }
}
