<?php

namespace App\Controller\Admin;

use App\Entity\Testimonials;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TestimonialsCrudController extends AbstractCrudController
{
    #[IsGranted('ROLE_USER')]
    public static function getEntityFqcn(): string
    {
        return Testimonials::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextareaField::new('comment', 'Commentaire'),
            ChoiceField::new('rate', 'Note')
                ->setChoices([
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ])
                ->renderExpanded()
                ->setRequired(true)
                ->setHelp('Notez de 1 à 5'),
            BooleanField::new('approved', 'Approuver')
                ->setProperty('approved'),
        ];
    }
}