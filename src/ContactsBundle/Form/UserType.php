<?php

namespace ContactsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['attr' => ['class' => "form-control"]])
            ->add('lastname', TextType::class, ['attr' => ['class' => "form-control"]])
            ->add('description', TextareaType::class, ['attr' => ['class' => "form-control"]])
            ->add('save', SubmitType::class, ['label' => 'Zapisz kontakt'], ['attr' => ['class' => "btn btn-default"]]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ContactsBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contactsbundle_user';
    }


}
