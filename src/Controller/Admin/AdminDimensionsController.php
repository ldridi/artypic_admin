<?php

namespace App\Controller\Admin;

use App\Entity\Dimensions;
use App\Form\DimensionsType;
use App\Repository\DimensionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dimensions')]
class AdminDimensionsController extends AbstractController
{
    #[Route('/', name: 'app_admin_dimensions_index', methods: ['GET'])]
    public function index(DimensionsRepository $dimensionsRepository): Response
    {
        return $this->render('admin_dimensions/index.html.twig', [
            'dimensions' => $dimensionsRepository->findBy(array(), array("id" => "DESC"))
        ]);
    }

    #[Route('/new', name: 'app_admin_dimensions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DimensionsRepository $dimensionsRepository): Response
    {
        $dimension = new Dimensions();
        $form = $this->createForm(DimensionsType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dimensionsRepository->save($dimension, true);

            return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dimensions/new.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dimensions_show', methods: ['GET'])]
    public function show(Dimensions $dimension): Response
    {
        return $this->render('admin_dimensions/show.html.twig', [
            'dimension' => $dimension,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_dimensions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dimensions $dimension, DimensionsRepository $dimensionsRepository): Response
    {
        $form = $this->createForm(DimensionsType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dimensionsRepository->save($dimension, true);

            return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dimensions/edit.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dimensions_delete', methods: ['POST'])]
    public function delete(Request $request, Dimensions $dimension, DimensionsRepository $dimensionsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dimension->getId(), $request->request->get('_token'))) {
            $dimensionsRepository->remove($dimension, true);
        }

        return $this->redirectToRoute('app_admin_dimensions_index', [], Response::HTTP_SEE_OTHER);
    }
}
