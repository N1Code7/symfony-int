<?php

namespace App\Form;

use App\DTO\SearchAuthorCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nom :",
                "required" => false
            ])
            ->add("orderBy", ChoiceType::class, [
                "label" => "Trier par :",
                "choices" => ["id" => "id", "Nom" => "name"],
                "required" => true
            ])
            ->add("direction", ChoiceType::class, [
                "label" => "Sens du tri :",
                "choices" => ["Croissant" => "ASC", "Décroissant" => "DESC"],
                "required" => true
            ])
            ->add("limit", NumberType::class, [
                "label" => "Nombre de résultats :",
                "required" => true
            ])
            ->add("page", NumberType::class, [
                "label" => "Nombre de page :",
                "required" => true
            ])
            ->add("submit", SubmitType::class, ["label" => "Rechercher"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => SearchAuthorCriteria::class,
            "method" => "GET",
            "csrf_protection" => false
        ]);
    }
}
