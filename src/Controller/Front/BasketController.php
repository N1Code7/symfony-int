<?php

namespace App\Controller\Front;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\BasketRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted("ROLE_USER")]
class BasketController extends AbstractController
{
    #[Route(path: '/mon-panier/{id}/ajouter', name: 'app_basket_addBook')]
    public function addBook(Book $book, BasketRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $basket = $user->getBasket();
        // dd($basket);
        $basket->addBook($book);

        $repository->add($basket, true);

        return $this->redirectToRoute("app_basket_displayBasket");
    }

    #[Route(path: "/mon-panier", name: "app_basket_displayBasket")]
    public function displayBasket(): Response
    {
        return $this->render("front/basket/displayBasket.html.twig");
    }

    #[Route(path: '/mon-panier/{id}/supprimer', name: 'app_basket_deleteBook')]
    public function deleteBook(Book $book, BasketRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $basket = $user->getBasket();
        // dd($basket);
        $basket->removeBook($book);

        $repository->add($basket, true);

        return $this->redirectToRoute("app_basket_displayBasket");
    }
}
