<?php

namespace App\Controller\Admin;

use App\Entity\Cgv;
use App\Form\CgvType;
use App\Repository\CgvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cgv')]
class AdminCgvController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    #[Route('/{id}', name: 'app_admin_cgv_index', methods: ['GET', 'POST'])]
    public function index(Request $request, Cgv $cgv, CgvRepository $cguRepository): Response
    {
        $form = $this->createForm(CgvType::class, $cgv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cguRepository->save($cgv, true);

            //return $this->redirectToRoute('app_admin_cgu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cgv/index.html.twig', [
            'cgv' => $cguRepository->find(1),
            'form' => $form,
        ]);
    }

    #[Route('/presentation/{id}', name: 'app_admin_cgv_show', methods: ['GET'])]
    public function show(Cgv $cgv): Response
    {
        return $this->render('admin_cgv/show.html.twig', [
            'cgv' => $cgv
        ]);
    }
}
