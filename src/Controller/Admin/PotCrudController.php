<?php

namespace App\Controller\Admin;

use App\Entity\Pot;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PotCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pot::class;
    }

    // On configure les champs
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            MoneyField::new('amount', 'Montant actuel')->setCurrency('EUR')->setStoredAsCents(false),
            DateField::new('dateGoal', 'Objectif de date')->hideOnIndex(),
            MoneyField::new('amountGoal', 'Montant à atteindre')->setCurrency('EUR')->setStoredAsCents(false)->hideOnIndex(),
            ChoiceField::new('type', 'Type')->setChoices([
                "Souple" => 0,
                "Mixte" => 1,
                "Strict" => 2,
            ]),
            DateField::new('createdAt', 'Créee le')->hideOnIndex(),
            DateField::new('updatedAt', 'Modifiée le')->hideOnForm()->hideOnIndex(),
            AssociationField::new('user', 'Utilisateur'),
            AssociationField::new('operations', 'Nombre d\'opérations'),
            CollectionField::new('operations', 'Opérations')->setTemplatePath('admin/operations.html.twig')->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Cagnotte')
            ->setEntityLabelInPlural('Cagnottes')
        ;
    }

    public function configureActions(Actions $actions): Actions 
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_DETAIL, Action::DELETE)
            ;
    }
    
}
