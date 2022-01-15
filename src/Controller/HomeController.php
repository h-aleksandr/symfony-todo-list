<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    #[Route('/', name: 'task_today', methods: ['GET', 'POST'])]
    public function showTodayTasks(TaskRepository $taskRepository): Response
    {
        $today = new \DateTime();
        //  return new JsonResponse(['url' => $this->generateUrl('home'), 'tasks' => $taskRepository->findAll(),]
    // );
        return $this->render('home/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
            // 'tasks' => $taskRepository->findByDate($today),
            'title' => 'task today',
            'today' => $today,
        ]);
    }
  
}
