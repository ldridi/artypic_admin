<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Review;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/product')]
class AdminProductController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }

    #[Route('/', name: 'app_admin_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin_product/index.html.twig', [
            'products' => $productRepository->findBy(array(), array("id" => "DESC"))
        ]);
    }

    #[Route('/new', name: 'app_admin_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $journalName = strtolower(preg_replace('/\s+/', '-', $product->getTitle()));
            $product->setSlug(random_int(100, 1001).'-'.$journalName);
            $product->setDiscount('');

            $file = $product->getImage();
            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads'), $fileName);
                $product->setImage($fileName);
            }else{
                $product->setImage("error.png");
            }

            $productRepository->add($product, true);

            return $this->redirectToRoute('app_admin_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        $productsReviews = $this->manager->getRepository(Review::class)->findBy(['product' => $product->getId()]);
        return $this->render('admin_product/show.html.twig', [
            'product' => $product,
            'reviews' => $productsReviews
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->get('imageHiddenProduct')->setData($product->getImage());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $journalName = strtolower(preg_replace('/\s+/', '-', $product->getTitle()));
            $product->setSlug(random_int(100, 1001).'-'.$journalName);
            $product->setDiscount('');

            $file = $product->getImage();
            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads'), $fileName);
                $product->setImage($fileName);
            }else{
                $username = $form->get('imageHiddenProduct')->getData();
                $product->setImage($username);
            }


            $productRepository->add($product, true);

            return $this->redirectToRoute('app_admin_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_admin_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
