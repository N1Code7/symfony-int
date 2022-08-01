<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_security_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            "last_username" => $lastUsername,
            "error" => $error
        ]);
    }

    #[Route("/deconnexion", name: "app_security_logout")]
    public function logout(): void
    {
        throw new \LogicException("This should never be reached !");
    }

    #[Route("/inscription", name: "app_security_registration")]
    public function registration(Request $request, UserRepository $repository, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $cryptedPassword = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($cryptedPassword);

            $repository->add($user, true);

            return $this->redirectToRoute("app_home_displayNBooks", ["number" => 20]);
        }

        return $this->render("security/signup.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[IsGranted("ROLE_USER")]
    #[Route("/mon_profile", name: "app_security_myProfile")]
    public function myProfile(Request $request, UserRepository $repository): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $repository->add($user, true);
        }

        return $this->render("security/myProfile.html.twig", [
            "form" => $form->createView(),
            "user" => $user
        ]);
    }
}
