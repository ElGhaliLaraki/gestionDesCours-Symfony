<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user= new User();

        $form= $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user , $user->getPassword());

           $user->setPassword($hash);
           $user->getStatut();
           $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            if($user->getStatut()==0){
                return $this->redirectToRoute('etudiant_new');
            }
            else{
                return $this->redirectToRoute('enseignant_new');
            }
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
