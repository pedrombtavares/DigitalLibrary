<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control mb-3', 
                'aria-label' => 'Name', 
                'aria-describedby' => 'basic-addon1'
            ]
        ])
            ->add('isbn', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'arial-label' => 'isbn',
                    'aria-describedby' => 'basic-addon1'
                ], 'label' => 'ISBN'
            ])
            ->add('author', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'aria-label' => 'Author',
                    'aria-describedby' => 'basic-addon1'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'aria-label' => 'Description',
                    'aria-describedby' => 'basic-addon1'
                ]
            ])
            ->add('cost', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control mb-3',
                    'aria-label' => 'Description',
                    'aria-describedby' => 'basic-addon1'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
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