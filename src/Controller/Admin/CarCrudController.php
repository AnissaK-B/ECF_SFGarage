<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $deleteImage = Action::new('removeImage', 'Supprimer l\'image')
            ->linkToCrudAction('removeImageFile');
    
        return $actions
            ->add(Crud::PAGE_DETAIL, $deleteImage)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setLabel('Ajouter une voiture');
            });
    }

    public function configureFields(string $pageName): iterable
    {
       $mappingsParams= $this->getParameter('vich_uploader.mappings');
       $carImagePath =  $mappingsParams['car']['uri_prefix'];
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('marque'),
            IntegerField::new('mileage'),
            NumberField::new('year', 'Année')->setNumberFormat('%d'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName')
                ->setBasePath($carImagePath)
                ->hideOnForm()
                ->setUploadDir('public/images/car')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
        ];
    }
}