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

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function showTodayTasks(TaskRepository $taskRepository): Response
    {
    //      return new JsonResponse(['url' => $this->generateUrl('home'), 'tasks' => $taskRepository->findByDate(new \DateTime()), 'title' => 'task today']
    // );
        return $this->render('home/index.html.twig', [
            'tasks' => $taskRepository->findByDate(new \DateTime()),
            'expired' => $taskRepository->findExpired(new \DateTime()),
        ]);
    }

    #[Route('/', name: 'base', methods: ['GET', 'POST'])]
    public function baseRender(TaskRepository $taskRepository): Response
    {
        return $this->render('base.html.twig', []);
    }
  
}
