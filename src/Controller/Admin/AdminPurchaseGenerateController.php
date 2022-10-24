<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\Purchase;
use App\Entity\PurchaseHistory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AdminPurchaseGenerateController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    /**
     * @Route("/generateInvoice/{token}", name="generate_invoice")
     */
    public function generateInvoice($token, EntityManagerInterface $manager, Pdf $pdf){
        $admin = $this->manager->getRepository(Admin::class)->find($this->getUser());
        $purchase = $manager->getRepository(Purchase::class)->find($token);
        $purchaseHistory = $manager->getRepository(PurchaseHistory::class)->findBy(['purchase' => $token]);
        $purchaseHistoryWithData = [];
        $datePurchase = new \DateTime($purchase->getDatePurchase());
        $total = 0;
        foreach ($purchaseHistory as $p){
            $remise = (int)$p->getProduct()->getDiscount() > 0 ? (int)$p->getProduct()->getPrice() - ((int)$p->getProduct()->getPrice() * (1- $p->getProduct()->getDiscount()/100)) : 0;
            $totalAfterCoupon = (int)$p->getProduct()->getPrice() - $remise;
            $purchaseHistoryWithData[] = [
                'id' => $p->getProduct()->getId(),
                'title' => $p->getProduct()->getTitle(),
                'price' => $p->getProduct()->getPrice(),
                'sku' => $p->getProduct()->getSku(),
                'discount' => $p->getProduct()->getDiscount(),
                'totalRemise' => $totalAfterCoupon
            ];

            $total += $totalAfterCoupon;
        }
        $html = $this->renderView('admin_purchases/invoice.html.twig', [
            'title' => "Welcome to our PDF Test",
            'tokenPurchase' => $purchase->getTokenPurchase(),
            'datePurchase' => $datePurchase->format('d-m-Y'),
            'nomSurnameUser' => $purchase->getUser()->getName().' '.$purchase->getUser()->getSurname(),
            'adresseUser' => $purchase->getUser()->getAdresse(),
            'cityUser' => $purchase->getUser()->getZipcode().' , '.$purchase->getUser()->getCity(),
            'countryUser' => $purchase->getUser()->getCountry(),
            'phoneUser' => $purchase->getUser()->getPhone(),
            'emailUser' => $purchase->getUser()->getEmail(),

            'companyImage' => $admin->getImage(),
            'companyName' => $admin->getCompanyName(),
            'companyEmail' => $admin->getCompanyEmail(),
            'companyAdresse' => $admin->getCompanyAdresse(),
            'companyCity' => $admin->getCompanyZipcode().' , '.$admin->getCompanyCity(),
            'companyCountry' => $admin->getCompanyCountry(),
            'companyPhone' => $admin->getCompanyPhone(),
            'companyTel' => $admin->getCompanyTel(),

            'products' => $purchaseHistoryWithData,
            'total' => $total
        ]);

        $filename = sprintf('%s.pdf', $datePurchase->format('d-m-Y')."_".$purchase->getTokenPurchase()."_".$purchase->getUser()->getName().'_'.$purchase->getUser()->getSurname());
        $options = [
            'page-size' => 'A4',
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,
        ];

        return new Response(
            $pdf->getOutputFromHtml($html,$options),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="%s"', $filename),
            ]
        );
    }

    /**
     * @Route("/sendInvoice", name="send_invoice", options={"expose"=true})
     */
    public function sendInvoice(Request $request, EntityManagerInterface $manager, Pdf $pdf){
        $admin = $this->manager->getRepository(Admin::class)->find($this->getUser());
        $token = $request->request->get('tokenInvoice');
        $purchase = $manager->getRepository(Purchase::class)->find($token);
        $purchaseHistory = $manager->getRepository(PurchaseHistory::class)->findBy(['purchase' => $token]);
        $purchaseHistoryWithData = [];
        $datePurchase = new \DateTime($purchase->getDatePurchase());
        $total = 0;
        foreach ($purchaseHistory as $p){
            $remise = (int)$p->getProduct()->getDiscount() > 0 ? (int)$p->getProduct()->getPrice() - ((int)$p->getProduct()->getPrice() * (1- $p->getProduct()->getDiscount()/100)) : 0;
            $totalAfterCoupon = (int)$p->getProduct()->getPrice() - $remise;
            $purchaseHistoryWithData[] = [
                'id' => $p->getProduct()->getId(),
                'title' => $p->getProduct()->getTitle(),
                'price' => $p->getProduct()->getPrice(),
                'sku' => $p->getProduct()->getSku(),
                'discount' => $p->getProduct()->getDiscount(),
                'totalRemise' => $totalAfterCoupon
            ];

            $total += $totalAfterCoupon;
        }
        $html = $this->renderView('admin_purchases/invoice.html.twig', [
            'title' => "Welcome to our PDF Test",
            'tokenPurchase' => $purchase->getTokenPurchase(),
            'datePurchase' => $datePurchase->format('d-m-Y'),
            'nomSurnameUser' => $purchase->getUser()->getName().' '.$purchase->getUser()->getSurname(),
            'adresseUser' => $purchase->getUser()->getAdresse(),
            'cityUser' => $purchase->getUser()->getZipcode().' , '.$purchase->getUser()->getCity(),
            'countryUser' => $purchase->getUser()->getCountry(),
            'phoneUser' => $purchase->getUser()->getPhone(),
            'emailUser' => $purchase->getUser()->getEmail(),
            'companyImage' => $admin->getImage(),
            'companyName' => $admin->getCompanyName(),
            'companyEmail' => $admin->getCompanyEmail(),
            'companyAdresse' => $admin->getCompanyAdresse(),
            'companyCity' => $admin->getCompanyZipcode().' , '.$admin->getCompanyCity(),
            'companyCountry' => $admin->getCompanyCountry(),
            'companyPhone' => $admin->getCompanyPhone(),
            'companyTel' => $admin->getCompanyTel(),

            'products' => $purchaseHistoryWithData,
            'total' => $total
        ]);

        $filename = sprintf('%s.pdf', $datePurchase->format('d-m-Y')."_".$purchase->getTokenPurchase()."_".$purchase->getUser()->getName().'_'.$purchase->getUser()->getSurname());
        $options = [
            'page-size' => 'A4',
            'margin-top'    => 0,
            'margin-right'  => 0,
            'margin-bottom' => 0,
            'margin-left'   => 0,
        ];

        $pdf = $pdf->getOutputFromHtml($html,$options);
        $transport = Transport::fromDsn($this->getParameter('app.dsn.mailer'));
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('artypicsf@artypicsf.dridi-lotfi.tech')
            ->to($purchase->getUser()->getEmail())
            ->subject('Facture numero : '. $purchase->getTokenPurchase())
            ->html('<p>Bonjour '.$purchase->getUser()->getName().' '.$purchase->getUser()->getSurname().' </p><p>Vous avez demandé recement votre facture pour la commande.</p><p> <b style="color: red">'.$purchase->getTokenPurchase().' </b></p></br><p>Cordialement.</p><p>Equipe @artypic</p>')
            ->attach($pdf, sprintf($filename));
        //->attach($pdf, sprintf('weekly-report-%s.pdf', date('Y-m-d')));
        $mailer->send($email);

        return new JsonResponse('ok');
    }
}