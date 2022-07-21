<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\PublishingHouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminPublishingHouseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de la maison d'édition :",
                "required" => true
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description de la maison d'édition :",
                "required" => false
            ])
            ->add('country', CountryType::class, [
                "label" => "Localisation (Pays) :",
                "required" => false
            ])
            ->add("books", EntityType::class, [
                "label" => "Livres appartenant à la maison d'édition :",
                "class" => Book::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Valider"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PublishingHouse::class,
        ]);
    }
}
