<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]

    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($user);
            $entityManager->flush();
            $data=$form->getData();
            $nom=$data->getNom();
            $prenom=$data->getPrenom();
            $email=$data->getEmail();
            return$this->render('content.html.twig',[
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email
            ]);
        }else{
            return $this->renderForm('base.html.twig',[
                'form' => $form

            ]);
        }

    }

}
