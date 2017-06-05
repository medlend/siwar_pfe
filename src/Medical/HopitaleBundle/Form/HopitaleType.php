<?php

namespace Medical\HopitaleBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HopitaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user',RegistrationFormType::class , array(
            'label' => false
        ))
            ->add('nomHopitale')
            ->add('mailHopitale')
            ->add('telHopitale')
            ->add('faxHopitale')
            ->add('hOuverture')
            ->add('hFermeture')
            ->add('siteWeb')
            ->add('latitude')
            ->add('longitude')     ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\HopitaleBundle\Entity\Hopitale'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'medical_hopitalebundle_hopitale';
    }


}
