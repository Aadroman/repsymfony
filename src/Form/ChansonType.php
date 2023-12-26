<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Chanson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use  Symfony\Bridge\Doctrine\Form\Type\EntityType;
use  Symfony\Component\Form\Extension\Core\Type\DateType;
use  Symfony\Component\Form\Extension\Core\Type\UrlType;

class ChansonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => ['placeholder' => 'Titre de la chanson',],
                "required"=> true,
            ])
            ->add('dateSortie', DateType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Date de sortie',
                'format' => 'dd MM yyyy',

            ])
            ->add('genre', TextType::class, [
                'attr' => ['placeholder' => 'Genre de la chanson',],
                "required"=> true,
            ])
            ->add('langue', TextType::class, [
                'attr' => ['placeholder' => 'Langue de la chanson',],
                "required"=> true,
            ])
            ->add('photoCouverture', UrlType::class, [
                'label' => 'Image URL',
                'attr' => ['placeholder' => 'URL de la couverture',],
            ])
            ->add('artistes', EntityType::class, [
                'class' => Artiste::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Artistes',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chanson::class,
        ]);
    }
}
