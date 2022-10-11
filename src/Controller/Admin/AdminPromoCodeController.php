<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\PromoCode;
use App\Form\PromoCodeType;
use App\Repository\PromoCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/promo/code')]
class AdminPromoCodeController extends AbstractController
{
    #[Route('/', name: 'app_admin_promo_code_index', methods: ['GET'])]
    public function index(PromoCodeRepository $promoCodeRepository): Response
    {
        return $this->render('admin_promo_code/index.html.twig', [
            'promo_codes' => $promoCodeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_promo_code_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $promoCode = new PromoCode();
        $form = $this->createForm(PromoCodeType::class, $promoCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($promoCode);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_promo_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_promo_code/new.html.twig', [
            'promo_code' => $promoCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_promo_code_show', methods: ['GET'])]
    public function show(PromoCode $promoCode): Response
    {
        return $this->render('admin_promo_code/show.html.twig', [
            'promo_code' => $promoCode,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_promo_code_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromoCode $promoCode, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PromoCodeType::class, $promoCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_promo_code_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_promo_code/edit.html.twig', [
            'promo_code' => $promoCode,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_promo_code_delete', methods: ['POST'])]
    public function delete(Request $request, PromoCode $promoCode, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promoCode->getId(), $request->request->get('_token'))) {
            $entityManager->remove($promoCode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_promo_code_index', [], Response::HTTP_SEE_OTHER);
    }
}
