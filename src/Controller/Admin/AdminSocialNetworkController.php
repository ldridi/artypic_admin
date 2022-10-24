<?php

namespace App\Controller\Admin;

use App\Entity\SocialNework;
use App\Form\SocialNeworkType;
use App\Repository\SocialNeworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/social/network')]
class AdminSocialNetworkController extends AbstractController
{
    #[Route('/', name: 'app_admin_social_network_index', methods: ['GET'])]
    public function index(SocialNeworkRepository $socialNeworkRepository): Response
    {
        return $this->render('admin_social_network/index.html.twig', [
            'social_neworks' => $socialNeworkRepository->findBy(array(), array("id" => "DESC"))
        ]);
    }

    #[Route('/new', name: 'app_admin_social_network_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocialNeworkRepository $socialNeworkRepository): Response
    {
        $socialNework = new SocialNework();
        $form = $this->createForm(SocialNeworkType::class, $socialNework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNeworkRepository->save($socialNework, true);

            return $this->redirectToRoute('app_admin_social_network_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_social_network/new.html.twig', [
            'social_nework' => $socialNework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_social_network_show', methods: ['GET'])]
    public function show(SocialNework $socialNework): Response
    {
        return $this->render('admin_social_network/show.html.twig', [
            'social_nework' => $socialNework,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_social_network_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SocialNework $socialNework, SocialNeworkRepository $socialNeworkRepository): Response
    {
        $form = $this->createForm(SocialNeworkType::class, $socialNework);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNeworkRepository->save($socialNework, true);

            return $this->redirectToRoute('app_admin_social_network_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_social_network/edit.html.twig', [
            'social_nework' => $socialNework,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_social_network_delete', methods: ['POST'])]
    public function delete(Request $request, SocialNework $socialNework, SocialNeworkRepository $socialNeworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialNework->getId(), $request->request->get('_token'))) {
            $socialNeworkRepository->remove($socialNework, true);
        }

        return $this->redirectToRoute('app_admin_social_network_index', [], Response::HTTP_SEE_OTHER);
    }
}
