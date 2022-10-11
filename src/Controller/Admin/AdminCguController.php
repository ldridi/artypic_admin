<?php

namespace App\Controller\Admin;

use App\Entity\Cgu;
use App\Form\CguType;
use App\Repository\CguRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cgu')]
class AdminCguController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    #[Route('/{id}', name: 'app_admin_cgu_index', methods: ['GET', 'POST'])]
    public function index(Request $request, Cgu $cgu, CguRepository $cguRepository): Response
    {
        $form = $this->createForm(CguType::class, $cgu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cguRepository->save($cgu, true);

            //return $this->redirectToRoute('app_admin_cgu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_cgu/index.html.twig', [
            'cgu' => $cguRepository->find(1),
            'form' => $form,
        ]);
    }

    #[Route('/presentation/{id}', name: 'app_admin_cgu_show', methods: ['GET'])]
    public function show(Cgu $cgu): Response
    {
        return $this->render('admin_cgu/show.html.twig', [
            'cgu' => $cgu
        ]);
    }
}
