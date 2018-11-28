<?php
/**
 * Created by PhpStorm.
 * User: Aristote
 * Date: 19/11/2018
 * Time: 16:55
 */

namespace App\Controller;


use App\Entity\Iencli;
use App\Repository\IencliRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class PropertyController extends AbstractController
{

    private $repository;
    /**
     * @var ObjectManager
     */
    private $en;

    public function __construct(IencliRepository $repository, ObjectManager $en)
    {
        $this->repository = $repository;
        $this->en = $en;
    }


    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('property/index.html.twig');
    }


     /**
     * @param Iencli $property
     * @param string $slug
     * @return Response
     */
    public function show(Iencli $property, string $slug): Response
    {
        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show',
                [
                   'id' => $property->getId(),
                   'slug' =>$property->getSlug()
                ],
                '301');
        }
        return $this->render('property/show.html.twig',
            [
                'property' => $property
            ]

        );
    }
}