<?php

namespace App\Controller\API;

use App\DTO\SearchAuthorCriteria;
use App\Form\API\ApiAuthorType;
use App\Form\API\ApiSearchAuthorType;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/api/authors")]
class AuthorController extends AbstractController
{
    #[Route('', name: 'app_api_author_create', methods: ["POST"])]
    public function create(Request $request, AuthorRepository $repository): Response
    {
        $form = $this->createForm(ApiAuthorType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();

            $repository->add($author, true);

            return $this->json($author, 201);
        }

        return $this->json($form->getErrors(), 400);
    }

    #[Route("", name: "app_api_author_list", methods: ["GET"])]
    public function list(Request $request, AuthorRepository $repository): Response
    {
        $criteria = new SearchAuthorCriteria();

        $form = $this->createForm(ApiSearchAuthorType::class, $criteria);

        $form->handleRequest($request);

        $authors = $repository->findByCriteria($criteria);

        return $this->json($authors);
    }

    #[Route("/{id}", name: "app_api_author_showOne", methods: ["GET"])]
    public function showOne(AuthorRepository $repository, int $id): Response
    {
        $author = $repository->find($id);

        return $this->json($author);
    }
}
