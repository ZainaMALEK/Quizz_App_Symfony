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

      $questions = $this->getDoctrine()
                         ->getRepository(Question::class)
                         ->findAll();

      return $this->render('question/index.html.twig', [
          'questions' => $questions
      ]);
  }



  /**
   * @Route("/question/{id}", name="question_detail")
   */
  public function detail($id)
  {

    $question = $this->getDoctrine()
      ->getRepository(Question::class)
      ->find($id);

      return $this->render('question/detail.html.twig', [
          'question' => $question
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


    /**
     * @Route("/question/edit/{id}", name="question_edit")
     */

      public function edit($id, Request $request)
        {
          $em = $this->getDoctrine()->getManager();
          // récupération des données
          $question = $em
            ->getRepository(Question::class)
            ->find($id);

          $form = $this->createForm(QuestionType::class, $question);

          $form->handleRequest($request);
          if ($form->isSubmitted()) {
            // modifie l'object category avec les données postées
            $question = $form->getData();
            $em->flush();
            return $this->redirectToRoute('question');
          }
          return $this->render('question/edit.html.twig', [
            'form' => $form->createView()
          ]);
        }

        /**
         * @Route("/question/delete{id}", name="question_delete")
         */
        public function delete($id)
        {
            $em = $this->getDoctrine()->getManager();
            $question = $this->getDoctrine()
              ->getRepository(Question::class)
              ->find($id);
            $em->remove($question);
            $em->flush();
            return $this->redirectToRoute('question');
        }


}
