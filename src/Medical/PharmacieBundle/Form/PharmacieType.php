<?php

namespace Medical\PharmacieBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PharmacieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',RegistrationFormType::class , array(
                'label' => false
            ))
            ->add('adresse')
            ->add('nomPharmacie')
            ->add('telPharmacie')
            ->add('faxPharmacie')
            ->add('hOuverture')
            ->add('hFermeture')
            ->add('siteWeb')
            ->add('image')
            ->add('type')       ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\PharmacieBundle\Entity\Pharmacie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'medical_pharmaciebundle_pharmacie';
    }


}
