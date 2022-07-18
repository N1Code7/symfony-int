<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Route("/")]
class AuthorController extends AbstractController
{
    #[Route('/admin/auteurs/nouveau', name: 'app_author_createAuthor')]
    public function createAuthor(Request $request, AuthorRepository $repository): Response
    {
        if (!$request->getMethod("POST")) {
            return $this->render('author/createAuthor.html.twig');
        }

        $name = $request->request->get("name");
        $description = $request->request->get("description");
        $imageUrl = $request->request->get("imageUrl");

        $author = new Author();
        $author->setName($name);
        $author->setDescription($description);
        $author->setImageUrl($imageUrl);

        $repository->add($author, true);

        return $this->redirectToRoute("app_author_list");
    }

    #[Route("/admin/auteurs", name: "app_author_list")]
    public function list(Request $request, AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();

        return $this->render(
            "author/list.html.twig",
            [
                "authors" => $authors
            ]
        );
    }
}
