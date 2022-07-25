<?php

namespace App\Controller\Front;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/livre/{id}', name: 'app_book_displayOneBook')]
    public function displayOneBook(BookRepository $repository, int $id): Response
    {
        $book = $repository->find($id);

        return $this->render('front/book/displayOneBook.html.twig', [
            'book' => $book,
        ]);
    }
}
