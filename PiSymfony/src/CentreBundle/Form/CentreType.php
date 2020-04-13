<?php

namespace CentreBundle\Form;

use CentreBundle\Entity\Centre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CentreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nomCentre',null, ['label'=> 'Nom du centre'])->add('adresseCentre',null, ['label'=> 'Adresse du centre'])->add('dasCentre')->add('mailCentre',null, ['label'=> 'Contact du centre'])->add('telephoneCentre',null, ['label'=> 'Telephone'])->add('imageCentre',FileType::class)->add('save',SubmitType::class);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CentreBundle\Entity\Centre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'centrebundle_centre';
    }
    public function getChoices()
    {
$output=[];
$output['Theatre']='Ther';
$output['Musique']="Musique";
$output['Peinture']='Peinture';

        $output['Autres']='Autres';
return $output;
    }


}
