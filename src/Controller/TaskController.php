<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'task_all', methods: ['GET', 'POST'])]
    public function showAllTasks(TaskRepository $taskRepository): Response
    {        
        return $this->render('task/show_all_tasks.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    #[Route('/expired', name: 'task_expired', methods: ['GET', 'POST'])]
    public function expired(TaskRepository $taskRepository): Response
    {
        return $this->render('task/expired.html.twig', [
             'expired' => $taskRepository->findExpired(new \DateTime()),
        ] );
    }

    #[Route('/completed', name: 'task_completed', methods: ['GET'])]
    public function completed(TaskRepository $taskRepository): Response
    {   
        return $this->render('task/completed.html.twig', [
            'completed' => $taskRepository->findBy(['completed' => true]),
        ]);
    }

    #[Route('/uncompleted', name: 'task_uncompleted', methods: ['GET'])]
    public function uncompleted(TaskRepository $taskRepository): Response
    {   
        return $this->render('task/uncompleted.html.twig', [
            'uncompleted' => $taskRepository->findBy(['completed' => false]),            
        ]);
    }

    #[Route('/new', name: 'task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TaskRepository $taskRepository): Response
    {   
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            return new JsonResponse(['url' => $this->generateUrl('home'),]);
        }

        //   return new JsonResponse(['url' => $this->generateUrl('home'), 'error' => 'failed to submit form data']);

        return $this->renderForm('task/_form.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

             return new JsonResponse(['url' => $this->generateUrl('home'),]);
        }

        return $this->renderForm('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

      #[Route('/search', name: 'task_search', methods: ['GET', 'POST'])]
    public function searchByDate(Request $request, TaskRepository $taskRepository): Response
    {
        if ($request->get('date')){
            $date = $request->get('date');
            $tasks = $taskRepository->findByDate(new \DateTime($date));

            return new JsonResponse(['url' => $this->generateUrl('home'), json_encode($searched)]);
        }

        return $this->render('task/searched.html.twig', [
        ]);
    }
 

}
