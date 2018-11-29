<?php

namespace App\Form;

use App\Entity\Iencli;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IencliType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('price')
            ->add('city')
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            ->add('heat', ChoiceType::class,
                [
                    'choices' => $this->getChoice()
                ])
            ->add('lenom')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Iencli::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoice()
    {
        $choices = Iencli::HEAT;
        $output = [];
        foreach ($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}
