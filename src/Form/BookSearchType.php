<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', SearchType::class, [
                'attr' => [
                    'class' => 'form-control mb-3', 
                    'aria-label' => 'Name', 
                    'aria-describedby' => 'basic-addon1'
                ], 'label' => 'Name'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ], 'label' => 'Search'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Book::class,
            'csrf_protection' => false
        ));
    }

}