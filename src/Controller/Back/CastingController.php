<?php

namespace App\Controller\Back;

use App\Entity\Casting;
use App\Form\CastingType;
use App\Repository\CastingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CastingController extends AbstractController
{
    /**
     * List Casting
     * @Route("back/casting/list", name="back_casting_list")
     */
    public function list(CastingRepository $castingRepository): Response
    {
        $castings = $castingRepository->findAllJoinedToPersonToMovieOrderByIdQB();

        dump($castings);

        return $this->render('back/casting/list.html.twig', [
             'castings' => $castings 
        ]);
    }

    /**
     *
     * Add Casting
     * @Route("back/casting/add", name="back_casting_add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $casting = new Casting();

        $form = $this->createForm(CastingType::class, $casting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($casting);
            $manager->flush();

            // dd($casting);

            $this->addFlash('success', 'Le casting n°' . $casting->getId() . ' a bien été ajouté !');

            return $this->redirectToRoute('back_casting_list');
        }

        return $this->render('back/casting/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     *
     * Add Casting
     * @Route("back/casting/edit/{id<\d+>}", name="back_casting_edit", methods={"GET", "POST"})
     */
    public function edit(Casting $casting = null, Request $request): Response
    {
        if ($casting === null) {
            throw $this->createNotFoundException('Casting non trouvé.');
        }

        $form = $this->createForm(CastingType::class, $casting);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($casting);
            $manager->flush();

            // dd($casting);

            $this->addFlash('success', 'Le casting n°' . $casting->getId() . ' a bien été modifié !');

            return $this->redirectToRoute('back_casting_edit', [ 'id' => $casting->getId() ]);
        }

        return $this->render('back/casting/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Delete Casting
     * @Route("back/casting/delete/{id<\d+>}", name="back_casting_delete")
     */
    public function delete(Casting $casting = null, EntityManagerInterface $entityManager): Response
    {
        if ($casting === null) {
            throw $this->createNotFoundException('Casting non trouvé.');
        }

        $entityManager->remove($casting);
        $entityManager->flush();

        $this->addFlash('success', 'Le casting a bien été supprimé !');

        return $this->redirectToRoute('back_casting_list');
}

}
