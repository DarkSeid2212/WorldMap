<?php
/**
 * Created by PhpStorm.
 * User: Aristote
 * Date: 30/11/2018
 * Time: 15:05
 */

namespace App\Controller;


use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        dump($lastUsername);
        return $this->render('security/login.html.twig',
            [
                'error' => $error,
                'lastUsername' => $lastUsername
            ]
        );
    }

    public function logout()
    {

    }

    /**
     * @param Request $request
     * @param ObjectManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function inscription(Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Users();
        $form = $this->createForm(UsersType::class, $utilisateur);

       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
            $encodage = $encoder->encodePassword($utilisateur, $form->get('password')->getData());
            $utilisateur->setPassword($encodage);
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('welcome', 'Le Bien a bien été ajouté');
            return $this->redirectToRoute('login');
        }
        return $this->render('security/inscription.html.twig',
            [
                'form' => $form->createView(),

            ]
        );
    }
}