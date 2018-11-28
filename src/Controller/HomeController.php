<?php
/**
 * Created by PhpStorm.
 * User: Aristote
 * Date: 19/11/2018
 * Time: 15:17
 */

namespace App\Controller;


use App\Repository\IencliRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{


    /**
     * @param IencliRepository $repository
     * @return Response
     */
    public function index(IencliRepository $repository): Response
    {
        $property = $repository->findLatest();

        return $this->render('pages/home.html.twig',
            [
                'properties' => $property
            ]);
    }
}