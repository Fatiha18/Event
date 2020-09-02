<?php

namespace App\Controller;

use App\Form\UserPasswordFormType;
use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/account", name="account_")
 * @IsGranted("ROLE_USER")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        // Formulaire de modifications des infos du profil
        $profileForm = $this->createForm(UserProfileFormType::class, $this->getUser());
        $profileForm->handleRequest($request);

        if ($profileForm->isSubmitted() && $profileForm->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Vos informations ont été mises à jour.');
        }


        // Formulaire de mise à jour du mot de passe
        $passwordForm = $this->createForm(UserPasswordFormType::class);
        $passwordForm->handleRequest($request);

        if ($passwordForm->isSubmitted() && $passwordForm->isValid()) {
            $password = $passwordForm->get('password')->getData();
            $hash = $encoder->encodePassword($this->getUser(), $password);

            $this->getUser()->setPassword($hash);

            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');

        }
        return $this->render('account/profile.html.twig', [
            'profile_form' => $profileForm->createView(),
            'password_form' => $passwordForm->createView(),
            
        ]);
    }
}   

