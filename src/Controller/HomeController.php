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

class HomeController extends AbstractController
{
      #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(TaskRepository $taskRepository): Response
    {
        $today = new \DateTime('today');
        return $this->render('home/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
            'today' => $today,
        ]);
    }
}
