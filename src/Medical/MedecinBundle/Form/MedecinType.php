<?php

namespace Medical\MedecinBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  ->add('user',RegistrationFormType::class , array(
                'label' => false
            ))
            ->add('description',TextareaType::class)
            ->add('numTel')
            ->add('fax')
            ->add('hOuverture')
            ->add('hFermeture')
            ->add('siteWeb')
            ->add('adresse')
           // ->add('latitude')
            //->add('longitude')
            ->add('specialite')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\MedecinBundle\Entity\Medecin'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'medical_medecinbundle_medecin';
    }


}
