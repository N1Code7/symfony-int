<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/categories")]
class CategoryController extends AbstractController
{
    #[Route('/nouvelle', name: 'app_category_createCategory')]
    public function createCategory(Request $request, CategoryRepository $repository): Response
    {



        if (!$request->isMethod("POST")) {
            return $this->render('category/createCategory.html.twig');
        }

        $name = $request->request->get("name");

        $category = new Category();
        $category->setName($name);

        $repository->add($category, true);

        return $this->redirectToRoute("app_category_list");
    }

    #[Route("/liste", name: "app_category_list")]
    public function list(CategoryRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render(
            "category/list.html.twig",
            [
                "categories" => $categories,
            ]
        );
    }

    #[Route("/modifier/{id}", name: "app_category_updateCategory")]
    public function updateCategory(Request $request, CategoryRepository $repository, int $id): Response
    {
        $category = $repository->find($id);

        if ($request->isMethod("POST")) {
            $name = $request->request->get("name");

            $category->getName($name);

            $repository->add($category, true);

            return $this->redirectToRoute("app_category_list");
        }

        return $this->render(
            "category/updateCategory.html.twig",
            [
                "category" => $category,
                "id" => $id
            ]
        );
    }

    #[Route("/supprimer/{id}", name: "app_category_deleteCategory")]
    public function deleteCategory(CategoryRepository $repository, int $id): Response
    {
        $category = $repository->find($id);

        $repository->remove($category, true);

        return $this->redirectToRoute("app_category_list");
    }
}
