<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permets à l'utilisateur de s'identifier
     * 
     * @Route("/login", name="account_login")
     *
     * @return Response
     */

    

    public function login(AuthenticationUtils $utils)
    {
        $error= $utils->getLastAuthenticationError();

        return $this->render('account/login.html.twig', [
            'hasError'=>$error !==null
        ]);
    }

    /**
     * Permet à l'utilisateur de se déconnecter
     *
     * @Route("/logout", name="account_logout")
     * 
     * @return Response 
     */
    public function logout(){}

    /**
     * Permet d'afficher le formulaire d'inscription
     * 
     * @Route("/register",name="account_register")
     * 
     * @return Response
     */

    public function register(Request $request,ManagerRegistry $manager, UserPasswordEncoderInterface $encoder){

        $user=new User();
                
        $form=$this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hash=$encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager->getManager()->persist($user);
            $manager->getManager()->flush();

            $this->addFlash(
                'succes',
                "Votre Compte a bien été enregistré ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }
        
        return $this->render('account/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }

}
