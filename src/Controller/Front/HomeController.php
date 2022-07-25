<?php

namespace App\Controller\Front;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/home/{number}', name: 'app_home_displayNTHBooks')]
    public function displayNTHBooks(BookRepository $repository, int $number): Response
    {
        $books = $repository->findLastNTH($number);

        return $this->render('front/home/displayNTHBooks.html.twig', [
            'books' => $books,
            "number" => $number
        ]);
    }
}
