<?php

namespace App\Controller\Front;

use App\Form\SearchBookType;
use App\DTO\SearchBookCriteria;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    #[Route('/home/{number}', name: 'app_home_displayNBooks')]
    public function displayNBooks(BookRepository $repository, int $number): Response
    {
        $books = $repository->findLastN($number);

        return $this->render('front/home/displayNBooks.html.twig', [
            'books' => $books,
            "number" => $number
        ]);
    }


    #[Route("/recherche", name: "app_home_search")]
    public function search(BookRepository $repository, Request $request): Response
    {
        $criteria = new SearchBookCriteria();

        $form = $this->createForm(SearchBookType::class, $criteria);

        $form->handleRequest($request);

        $books = $repository->findByCriteria($criteria);

        return $this->render("front/home/search.html.twig", [
            "form" => $form->createView(),
            "books" => $books
        ]);
    }
}
