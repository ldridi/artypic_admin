<?php

namespace App\Controller\Admin;

use \Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin;
use App\Form\User1Type;
use App\Repository\UserRepository;
use PHPUnit\TextUI\XmlConfiguration\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/settings')]
class AdminSettingsController extends AbstractController
{
    #[Route('/', name: 'app_admin_settings_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $admin = $this->getUser();
        return $this->render('admin_settings/index.html.twig', [
            'admin' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: 'app_admin_settings_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admin = $entityManager->getRepository(Admin::class)->find($this->getUser());

        $form = $this->createForm(User1Type::class,$admin);
        $form->get('imageHidden')->setData($admin->getImage());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $admin->getImage();
            if ($file instanceof UploadedFile) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('uploads'), $fileName);
                $admin->setImage($fileName);
            }else{
                $username = $form->get('imageHidden')->getData();
                $admin->setImage($username);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_settings_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_settings/edit.html.twig', [
            'admin' => $admin,
            'image' => $admin->getImage(),
            'form' => $form,
        ]);
    }
}
