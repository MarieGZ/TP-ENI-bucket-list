<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/wish/ajouter", name="wish_add")
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $wish = new Wish();
        $wish->setDateCreated(new \DateTime());
        $wish->setIsPublished('true');
        $wishForm = $this->createForm(WishType::class, $wish);

        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            $entityManager->persist($wish);
            $entityManager->flush();

            $this->addFlash('success', 'Votre voeu a bien été ajouté !');
            return $this->redirectToRoute('wish_details', ['id'=>$wish->getId()]);
        }

        return $this->render('wish/add.html.twig', [
            'wishForm'=>$wishForm->createView()
        ]);
    }
}
