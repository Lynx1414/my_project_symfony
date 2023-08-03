<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }

public function configureFields( string $pageName ): iterable
 {
    return [
        IntegerField::new('id', 'ID')->onlyOnIndex(),
        EmailField::new('email', 'Email'),
        // TextField::new('password', 'Password'),
        ChoiceField::new('roles', 'Role de l\'utilisateur ')
        ->setChoices(array(
            'ROLE_ADMIN'=> 'ROLE_ADMIN',
            'ROLE_USER'=> 'ROLE_USER',
        ))
        ->allowMultipleChoices(true),
        BooleanField::new('isVerified', true),
    ];
 }
    // private UserPasswordHasherInterface $passwordEncoder;

    // public function __construct( UserPasswordHasherInterface $passwordEncoder ) {
    //     $this->passwordEncoder = $passwordEncoder;
    // }

    // public static function getEntityFqcn(): string {
    //     return User::class;
    // }

    // public function configureFields( string $pageName ): iterable {
    //     yield FormField::addPanel( 'User data' )->setIcon( 'fa fa-user' );
    //     yield EmailField::new( 'email' )->onlyWhenUpdating()->setDisabled();
    //     yield EmailField::new( 'email' )->onlyWhenCreating();
    //     yield TextField::new( 'email' )->onlyOnIndex();
    //     $roles = ['ROLE_ADMIN', 'ROLE_USER' ];
    //     yield ChoiceField::new( 'roles' )
    //                      ->setChoices( array_combine( $roles, $roles ) )
    //                      ->allowMultipleChoices()
    //                      ->renderAsBadges();
    //     yield FormField::addPanel( 'Change password' )->setIcon( 'fa fa-key' );
    //     yield Field::new( 'password', 'New password' )->onlyWhenCreating()->setRequired( true )
    //                ->setFormType( RepeatedType::class )
    //                ->setFormTypeOptions( [
    //                    'type'            => PasswordType::class,
    //                    'first_options'   => [ 'label' => 'New password' ],
    //                    'second_options'  => [ 'label' => 'Repeat password' ],
    //                    'error_bubbling'  => true,
    //                    'invalid_message' => 'The password fields do not match.',
    //                ] );
    //     yield Field::new( 'password', 'New password' )->onlyWhenUpdating()->setRequired( false )
    //                ->setFormType( RepeatedType::class )
    //                ->setFormTypeOptions( [
    //                    'type'            => PasswordType::class,
    //                    'first_options'   => [ 'label' => 'New password' ],
    //                    'second_options'  => [ 'label' => 'Repeat password' ],
    //                    'error_bubbling'  => true,
    //                    'invalid_message' => 'The password fields do not match.',
    //                ] );
    // }
}
