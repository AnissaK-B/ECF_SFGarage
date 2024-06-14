<?php

namespace App\Form;


use App\Entity\Formulaire;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Email(),

                ],
            ])
            ->add('name',TextType::class,[
                'constraints' =>[
                    new Assert\NotBlank(),
                    new Assert\Length([
                        'min'=>2,
                        'max'=> 255,
                    ]),
                ],
            ])
            ->add('lastname',TextType::class,[
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'min' =>2,
                    'max'=>255,
                ]),
            ],
            ])
            ->add('tel',TextType::class,[
                'constraints' =>[
                    new Assert\Regex([
                        'pattern'=> '/^[0-9]{10}$/',
                        'message'=>'Le numero e téléphone doit comporter 10 chiffres',
                    ]),
                ],
            ])
            ->add('message',TextareaType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\length([
                        'min'=>10,
                        'max'=>1000,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formulaire::class,
        ]);
    }
}
