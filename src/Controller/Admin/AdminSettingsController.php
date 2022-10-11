<?php

namespace App\Controller\Admin;

use \Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/settings')]
class AdminSettingsController extends AbstractController
{
    #[Route('/', name: 'app_admin_settings_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $admin = $entityManager->getRepository(User::class)->find(1);
        return $this->render('admin_settings/index.html.twig', [
            'user' => $admin,
        ]);
    }

    #[Route('/new', name: 'app_admin_settings_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_settings/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/show', name: 'app_admin_settings_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('admin_settings/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: 'app_admin_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admin = $entityManager->getRepository(User::class)->find(1);
        $form = $this->createForm(User1Type::class,$admin);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $admin->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads'), $fileName);
            $admin->setImage($fileName);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_settings_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_settings/edit.html.twig', [
            'user' => $admin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_settings_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_settings_index', [], Response::HTTP_SEE_OTHER);
    }
}
