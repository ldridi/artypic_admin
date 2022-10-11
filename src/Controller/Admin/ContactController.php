<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="contact")
     */
    public function index(){
       return $this->render("admin_contact/index.html.twig");
    }
}