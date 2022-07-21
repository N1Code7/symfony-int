<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\PublishingHouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AdminBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre du livre :",
                "required" => true
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix du livre :",
                "required" => true
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description du livre :",
                "required" => false
            ])
            ->add('imageUrl', UrlType::class, [
                "label" => "URL de l'image :",
                "required" => false
            ])
            ->add('author', EntityType::class, [
                "class" => Author::class,
                "choice_label" => "name",
                "label" => "Choix de l'auteur :",
                "required" => false
            ])
            ->add('categories', EntityType::class, [
                "class" => Category::class,
                "choice_label" => "name",
                "multiple" => true,
                "expanded" => true,
                "label" => "Choix des catégories :",
                "required" => false
            ])
            ->add("publishingHouse", EntityType::class, [
                "class" => PublishingHouse::class,
                "choice_label" => "name",
                "label" => "Maison d'édition",
                "required" => false
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Valider"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
