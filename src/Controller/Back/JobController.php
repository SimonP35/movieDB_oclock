<?php

namespace App\Controller\Back;

use DateTime;
use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobController extends AbstractController
{
    /**
     * List Job
     * @Route("back/job/list", name="back_job_list")
     */
    public function list(JobRepository $jr): Response
    {
        $jobs = $jr->findAllJoinedToDepartmentOrderByIdQB();
        
        dump($jobs);

        return $this->render('back/job/list.html.twig', [
             'jobs' => $jobs 
        ]);
    }

    /**
     *
     * Add Job
     * @Route("back/job/add", name="back_job_add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $job
            ->setCreatedAt(new DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($job);
            $manager->flush();

            // dd($job);

            $this->addFlash('success', 'Le job ' . $job->getName() . ' a bien été ajouté !');

            return $this->redirectToRoute('back_job_list');
        }

        return $this->render('back/job/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     *
     * Add Job
     * @Route("back/job/edit/{id<\d+>}", name="back_job_edit", methods={"GET", "POST"})
     */
    public function edit(Job $job = null, Request $request): Response
    {
        if ($job === null) {
            throw $this->createNotFoundException('Job non trouvé.');
        }

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $job
            ->setUpdatedAt(new DateTime());

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($job);
            $manager->flush();

            // dd($job);

            $this->addFlash('success', 'Le job ' . $job->getName() . ' a bien été modifié !');

            return $this->redirectToRoute('back_job_edit', [ 'id' => $job->getId() ]);
        }

        return $this->render('back/job/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Delete Job
     * @Route("back/job/delete/{id<\d+>}", name="back_job_delete")
     */
    public function delete(Job $job = null, EntityManagerInterface $entityManager): Response
    {
        if ($job === null) {
            throw $this->createNotFoundException('Job non trouvé.');
        }

        $entityManager->remove($job);
        $entityManager->flush();

        $this->addFlash('success', 'Le Job a bien été supprimé !');

        return $this->redirectToRoute('back_job_list');
}

}
