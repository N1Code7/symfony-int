<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AdminAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/auteurs")]
class AuthorController extends AbstractController
{
    #[Route("/nouveau", name: 'app_author_createAuthor')]
    public function createAuthor(Request $request, AuthorRepository $repository): Response
    {
        $author = new Author();

        $form = $this->createForm(AdminAuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $repository->add($author, true);

            return $this->redirectToRoute("app_author_list");
        }
        return $this->render("author/createAuthor.html.twig", [
            "form" => $form->createView()
        ]);

        // if (!$request->isMethod("POST")) {
        //     return $this->render('author/createAuthor.html.twig');
        // }

        // $name = $request->request->get("name");
        // $description = $request->request->get("description");
        // $imageUrl = $request->request->get("imageUrl");

        // $author = new Author();
        // $author->setName($name);
        // $author->setDescription($description);
        // $author->setImageUrl($imageUrl);

        // $repository->add($author, true);

        // return $this->redirectToRoute("app_author_list");
    }

    #[Route("/liste", name: "app_author_list")]
    public function list(AuthorRepository $repository): Response
    {
        $authors = $repository->findAll();

        return $this->render(
            "author/list.html.twig",
            [
                "authors" => $authors
            ]
        );
    }

    #[Route("/modifier/{id}", name: "app_author_updateAuthor")]
    public function updateAuthor(Request $request, AuthorRepository $repository, int $id): Response
    {
        $author = $repository->find($id);

        $form = $this->createForm(AdminAuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $repository->add($author, true);

            return $this->redirectToRoute("app_author_list");
        }
        return $this->render("author/createAuthor.html.twig", [
            "form" => $form->createView()
        ]);


        // if ($request->isMethod("POST")) {

        //     $name = $request->request->get("name");
        //     $description = $request->request->get("description");
        //     $imageUrl = $request->request->get("imageUrl");

        //     $author->setName($name);
        //     $author->setDescription($description);
        //     $author->setImageUrl($imageUrl);

        //     $repository->add($author, true);

        //     return $this->redirectToRoute("app_author_list");
        // }

        // return $this->render("author/updateAuthor.html.twig", [
        //     "id" => $id,
        //     "author" => $author
        // ]);
    }

    #[Route("/supprimer/{id}", name: "app_author_deleteAuthor")]
    public function deleteAuthor(AuthorRepository $repository, int $id): Response
    {
        $author = $repository->find($id);

        $repository->remove($author, true);

        return $this->redirectToRoute("app_author_list");
    }
}
