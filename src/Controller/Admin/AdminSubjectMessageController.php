<?php

namespace App\Controller\Admin;

use App\Entity\SubjectMessage;
use App\Form\SubjectMessageType;
use App\Repository\SubjectMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/subject/message')]
class AdminSubjectMessageController extends AbstractController
{
    #[Route('/', name: 'app_admin_subject_message_index', methods: ['GET'])]
    public function index(SubjectMessageRepository $subjectMessageRepository): Response
    {
        return $this->render('admin_subject_message/index.html.twig', [
            'subject_messages' => $subjectMessageRepository->findBy(array(), array("id" => "DESC"))
        ]);
    }

    #[Route('/new', name: 'app_admin_subject_message_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubjectMessageRepository $subjectMessageRepository): Response
    {
        $subjectMessage = new SubjectMessage();
        $form = $this->createForm(SubjectMessageType::class, $subjectMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectMessageRepository->save($subjectMessage, true);

            return $this->redirectToRoute('app_admin_subject_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_subject_message/new.html.twig', [
            'subject_message' => $subjectMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_subject_message_show', methods: ['GET'])]
    public function show(SubjectMessage $subjectMessage): Response
    {
        return $this->render('admin_subject_message/show.html.twig', [
            'subject_message' => $subjectMessage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_subject_message_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubjectMessage $subjectMessage, SubjectMessageRepository $subjectMessageRepository): Response
    {
        $form = $this->createForm(SubjectMessageType::class, $subjectMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subjectMessageRepository->save($subjectMessage, true);

            return $this->redirectToRoute('app_admin_subject_message_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_subject_message/edit.html.twig', [
            'subject_message' => $subjectMessage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_subject_message_delete', methods: ['POST'])]
    public function delete(Request $request, SubjectMessage $subjectMessage, SubjectMessageRepository $subjectMessageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subjectMessage->getId(), $request->request->get('_token'))) {
            $subjectMessageRepository->remove($subjectMessage, true);
        }

        return $this->redirectToRoute('app_admin_subject_message_index', [], Response::HTTP_SEE_OTHER);
    }
}
