<?php


namespace CentreBundle\Form;


use CentreBundle\Entity\CentreSearch;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class rechercheCentreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',null,['label'=>'Tapez le nom du centre à chercher']);
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
$resolver->setDefaults(
    [
        'data_class' =>CentreSearch::class,
        'method'=>'get',
'csrf_protection' =>false
    ]
);
    }

public function  getBlockPrefix()
{
    return  '';
}
}