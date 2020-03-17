<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ordinateur;
use App\Entity\Marque;
use App\Form\Type\OrdinateurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MarqueRepository;

class OrdinateurController extends AbstractController
{
    /**
     * @Route("/ordinateur", name="ordinateur")
     */
    public function index()
    {
        return $this->render('ordinateur/index.html.twig', [
            'controller_name' => 'OrdinateurController',
        ]);
    }

    /**
     * @Route("/ajout_ordinateur", name="ajout_ordinateur")
     */
    public function ajouter(Request $request)
    {
        $ordinateur = new Ordinateur;
        $form = $this->createForm(OrdinateurType::class, $ordinateur);
        $form->add(
            'submit',
            SubmitType::class,
            array('label' => 'Ajouter')
        );
        $form->add(
            'marque',
            EntityType::class,
            array(
                'class' => Marque::class,
                'query_builder' => function (MarqueRepository $repo) {
                    return $repo->createQueryBuilder('m')
                        ->where('length(m.nom) <= 4');
                }
            )
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ordinateur);
            $entityManager->flush();
            return $this->redirectToRoute('ordinateur');
        }
        return $this->render(
            'ordinateur/ajouter.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }
}
