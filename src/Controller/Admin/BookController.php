<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Form\AdminBookType;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/livres")]
class BookController extends AbstractController
{
    #[Route("/nouveau", name: "app_book_createBook")]
    public function createBook(Request $request, BookRepository $repository): Response
    {
        $form = $this->createForm(AdminBookType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $repository->add($book, true);

            return $this->redirectToRoute("app_book_list");
        }

        return $this->render(
            "book/createBook.html.twig",
            [
                "form" => $form->createView()
            ]
        );
    }

    #[Route("/liste", name: "app_book_list")]
    public function list(BookRepository $repository): Response
    {
        $books = $repository->findAll();

        return $this->render(
            "book/list.html.twig",
            [
                "books" => $books,
            ]
        );
    }

    #[Route("/modifier/{id}", name: "app_book_updateBook")]
    public function updateBook(Request $request, BookRepository $repository, int $id): Response
    {
        $book = $repository->find($id);

        $form = $this->createForm(AdminBookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $repository->add($book, true);

            return $this->redirectToRoute("app_book_list");
        }

        return $this->render("book/updateBook.html.twig", [
            "form" => $form->createView(),
            "book" => $book
        ]);
    }

    #[Route("/supprimer/{id}", name: "app_book_deleteBook")]
    public function deleteBook(BookRepository $repository, int $id): Response
    {
        $book = $repository->find($id);

        $repository->remove($book, true);

        return $this->redirectToRoute("app_book_list");
    }
}
