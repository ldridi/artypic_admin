<?php

namespace App\Controller\Admin;

use App\Entity\Cgu;
use App\Entity\CguCgv;
use App\Entity\Message;
use App\Entity\Product;
use App\Entity\Purchase;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(){
        $clients = $this->manager->getRepository(User::class)->findAll();
        $produits = $this->manager->getRepository(Product::class)->findAll();
        $purchases = $this->manager->getRepository(Purchase::class)->findAll();
        $reviews = $this->manager->getRepository(Review::class)->findAll();
        return $this->render("dashboard/index.html.twig", ['clients' => $clients,'produits' => $produits,'purchases' => $purchases,'reviews' => $reviews]);
    }

    /**
     * @Route("/dashboard/notifications", name="dashboard_notifications", options={"expose"=true})
     */
    public function purchaseNotifications(Request $request, EntityManagerInterface $manager){
        $purchaseCount = count($manager->getRepository(Purchase::class)->findBy(['consulted' => 0]));
        return new JsonResponse($purchaseCount);
    }

    /**
     * @Route("/dashboard/message/notifications", name="dashboard_message_notifications", options={"expose"=true})
     */
    public function messageNotification(Request $request, EntityManagerInterface $manager){
        $messageCount = count($manager->getRepository(Message::class)->findBy(['statut' => 0]));
        return new JsonResponse($messageCount);
    }

}