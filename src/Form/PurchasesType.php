<?php

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchasesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class,["attr" => ["class" => "select2-basic"], 'label' => 'Pays', 'choices' => [
                "En Attente"=>"En Attente",
                "Expedié"=>"Expedié",
                "Livré"=>"Livré",

            ]])
            ->add('paiementStatus', ChoiceType::class,["attr" => ["class" => "select2-basic"], 'label' => 'Pays', 'choices' => [
                "En Attente"=>"En Attente",
                "unpaid"=>"unpaid",
                "payé"=>"payé"

            ]])
            ->add('trackLink', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Purchase::class,
        ]);
    }
}
