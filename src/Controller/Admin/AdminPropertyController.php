<?php
/**
 * Created by PhpStorm.
 * User: Aristote
 * Date: 29/11/2018
 * Time: 16:00
 */

namespace App\Controller\Admin;


use App\Entity\Iencli;
use App\Form\IencliType;
use App\Repository\IencliRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminPropertyController extends AbstractController
{
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * AdminPropertyController constructor.
     * @param IencliRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(IencliRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/index.html.twig',
            [
                'properties' => $properties
            ]
        );

    }

    /**
     * @param Iencli $property
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Iencli $property, Request $request)
    {
        $form = $this->createForm(IencliType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Le Bien a bien été modifié');

            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/edit.html.twig',
            [
                'property' => $property,
                'form' => $form->createView()
            ]
        );
    }

    public function add(Request $request)
    {
        $property = new Iencli();
        $form = $this->createForm(IencliType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success','Le Bien a bien été ajouté');
            return $this->redirectToRoute('admin.index');
        }
        return $this->render('admin/add.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }


    public function delete(Iencli $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success','Le Bien a bien été supprimé');

        }
        return $this->redirectToRoute('admin.index');


    }

}