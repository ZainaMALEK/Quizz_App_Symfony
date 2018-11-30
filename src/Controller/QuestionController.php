<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\QuestionType;
use App\Entity\Category;
use App\Entity\Question;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="question")
     */
    public function index()
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }


    /**
     * @Route("/question/add", name="question_add")
     */
    public function add(Request $request)
    {

        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);


        $form->handleRequest($request);
          if ($form->isSubmitted())
          {
            $question = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
          }
          return $this->render('question/add.html.twig', [
            'form' => $form->createView()
          ]);

    }
}
