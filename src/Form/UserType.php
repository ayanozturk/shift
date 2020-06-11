<?php

namespace App\Form;

use App\Entity\User;
use App\Preferences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('firstName', TextType::class)
            ->setRequired(true);

        $builder->add('lastName', TextType::class)
            ->setRequired(true);

        $builder->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'constraints' => [new Length(['min' => 8])],
            'first_options' => ['label' => 'Password'],
            'second_options' => ['label' => 'Repeat Password'],
        ])->setRequired(true);

        $builder->add('email', EmailType::class)
            ->setRequired(true);

        $builder->add('roles', ChoiceType::class, [
            'multiple' => true,
            'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN',
            ],
        ])->setRequired(true);

        $builder->add('preferences', ChoiceType::class, [
            'multiple' => true,
            'choices' => [
                'Weekend Only' => Preferences::WEEKEND_ONLY
            ],
        ]);

        $builder->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
