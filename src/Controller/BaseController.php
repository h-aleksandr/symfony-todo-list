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

class BaseController extends AbstractController
{
    //   #[Route('/', name: 'home', methods: ['GET', 'POST'])]
     public function __construct(
        private TaskRepository $taskRepository,
    ) {
    }

    public function renderDafault(): Response
    {
        return $this->render([
            'tasks' => $this->taskRepository->findAll(),
            'today' => new \DateTime('today'),
            'tasks_other' => $this->taskRepository->findAll(),
        ]);
    }
   
}
