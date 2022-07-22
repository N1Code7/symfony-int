<?php

namespace App\Controller\Admin;

use App\Form\AdminPublishingHouseType;
use App\Repository\PublishingHouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/maison_edition")]
class PublishingHouseController extends AbstractController
{
    #[Route('/nouvelle', name: 'app_publishing_house_createHouse')]
    public function createCategory(Request $request, PublishingHouseRepository $repository): Response
    {
        $form = $this->createForm(AdminPublishingHouseType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $house = $form->getData();

            $repository->add($house, true);

            return $this->redirectToRoute("app_publishing_house_list");
        }

        return $this->render("publishing_house/createHouse.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route("/liste", name: "app_publishing_house_list")]
    public function list(PublishingHouseRepository $repository): Response
    {
        $houses = $repository->findAll();

        return $this->render(
            "publishing_house/list.html.twig",
            [
                "houses" => $houses
            ]
        );
    }

    #[Route("/modifier/{id}", name: "app_publishing_house_updateHouse")]
    public function updateCategory(Request $request, PublishingHouseRepository $repository, int $id): Response
    {
        $house = $repository->find($id);

        $form = $this->createForm(AdminPublishingHouseType::class, $house);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $repository->add($house, true);

            return $this->redirectToRoute("app_publishing_house_list");
        }

        return $this->render("publishing_house/updateHouse.html.twig", [
            "form" => $form->createView(),
            "house" => $house
        ]);
    }

    #[Route("/supprimer/{id}", name: "app_publishing_house_deleteHouse")]
    public function deleteCategory(PublishingHouseRepository $repository, int $id): Response
    {
        $house = $repository->find($id);

        $repository->remove($house, true);

        return $this->redirectToRoute("app_publishing_house_list");
    }
}
