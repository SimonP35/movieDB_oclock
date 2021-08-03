<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Préfixe pour toutes les routes de ce contrôleur 
 * @Route("/back/user/", name="back_user_")
 */
class UserController extends AbstractController
{
    /**
     * List User
     * @Route("list", name="list")
     */
    public function list(UserRepository $ur): Response
    {
        $users = $ur->findAll();

        //? Queries Customs (Repository)
        // $movies = $movieRepository->findAllOrderByTitleAscQB();
        // $movies = $movieRepository->findAllOrderByTitleAscDQL();

        dump($users);

        return $this->render('back/user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Add User
     * @Route("add", name="add", methods={"GET", "POST"})
     */
    public function add(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();


            $this->addFlash('success', 'L\'utilisateur ' . $user->getEmail() . ' a bien été ajouté !');

            return $this->redirectToRoute('back_user_list');
        }

        return $this->render('back/user/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Add User
     * @Route("edit/{id<\d+>}", name="edit", methods={"GET", "POST"})
     */
    public function edit(User $user = null, Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($user === null) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Si le mot de passe du form n'est pas vide
            // c'est qu'on veut le changer !
            if ($form->get('password')->getData() != '') {
                $hashedPassword = $passwordHasher->hashPassword($user, $form->get('password')->getData());
                $user->setPassword($hashedPassword);
            }

            $manager = $this->getDoctrine()->getManager();

            $manager->flush();

            // dd($user);

            $this->addFlash('success', 'L\'utilisateur ' . $user->getEmail() . ' a bien été modifié !');

            return $this->redirectToRoute('back_user_edit', ['id' => $user->getId()]);
        }

        return $this->render('back/user/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Delete User
     * @Route("delete/{id<\d+>}", name="delete")
     */
    public function delete(User $user = null, EntityManagerInterface $entityManager): Response
    {
        if ($user === null) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé !');

        return $this->redirectToRoute('back_user_list');
    }
}
