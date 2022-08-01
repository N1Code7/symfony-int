<?php

namespace App\Form\API;

use App\Form\SearchAuthorType;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiSearchAuthorType extends SearchAuthorType
{
    public function getBlockPrefix(): string
    {
        return "";
    }
}
