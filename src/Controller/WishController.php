<?php

namespace App\Controller;

use App\Repository\WishRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy([],['dateCreated'=>'DESC'],20);
        return $this->render('wish/list.html.twig', [
        "wishes" => $wishes
        ]);
    }

    /**
     * @Route("/wish/details/{id}", name="wish_details")
     */
    public function details($id, WishRepository $wishRepository): Response
    {
        $wish =$wishRepository->find($id);
        return $this->render('wish/details.html.twig', [
            'wish'=>$wish
        ]);
    }
}
