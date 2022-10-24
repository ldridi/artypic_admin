<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Purchase;
use App\Entity\PurchaseHistory;
use App\Form\CategoryType;
use App\Form\PurchasesType;
use App\Repository\CategoryRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/purchases')]
class AdminPurchasesController extends AbstractController
{
    #[Route('/', name: 'app_admin_purchases_index', methods: ['GET'])]
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('admin_purchases/index.html.twig', [
            'purchases' => $purchaseRepository->findBy(array(), array("id" => "DESC"))
        ]);
    }

    #[Route('/{id}', name: 'app_admin_purchases_show', methods: ['GET'])]
    public function show(Purchase $purchase, EntityManagerInterface $manager): Response
    {
        $purchase->setConsulted(1);
        $manager->flush();
        $products = $manager->getRepository(PurchaseHistory::class)->findBy(['purchase' => $purchase]);
        $productsWithData = [];
        foreach ($products as $product){
            $productsWithData[] = [
                'id' => $product->getProduct()->getId(),
                'image' => $product->getProduct()->getImage(),
                'title' => $product->getProduct()->getTitle(),
                'createdAt' => $product->getProduct()->getCreatedAt(),
                'status' => $product->getProduct()->isStatus(),
                'price' => $product->getProduct()->getPrice(),
                'sku' => $product->getProduct()->getSku(),
                'enabled' => $product->getProduct()->isEnabled()
            ];
        }
        return $this->render('admin_purchases/show.html.twig', [
            'purchase' => $purchase,
            'products' => $productsWithData
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_purchases_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Purchase $purchase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurchasesType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_purchases_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_purchases/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form,
        ]);
    }


}
