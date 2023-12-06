<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use  Symfony\Component\Form\Extension\Core\Type\TextareaType;
use  Symfony\Component\Form\Extension\Core\Type\UrlType;
use  Symfony\Component\Form\Extension\Core\Type\DateType;
use  Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Cocur\Slugify\Slugify;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use SebastianBergmann\CodeCoverage\Driver\WriteOperationFailedException;
use DateTimeImmutable;
use DateTimeZone;
use DateTime;



class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['placeholder' => 'the title...',],
                "required"=> true,
            ])
            ->add('slug', TextType::class, [
                'required' => false,
                'attr' => [
                    'style' => 'display: none;', // This will hide the field
                ],
                'label_attr' => [
                    'style' => 'display: none;', // This will hide the label
                ],
            ])
            ->add('context', TextareaType::class, [
                'label' => 'Context',
            ])
            ->add('imageUrl', UrlType::class, [
                'label' => 'Image URL',
            ])
            // Add the 'createdAt' and 'updatedAt' fields with the specified format
            ->add('createdAt', DateType::class, [
                'input' => 'datetime_immutable',
                'label' => 'Created At',
                'format' => 'dd MM yyyy HH mm ss',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                'label' => 'Author',
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => true,
                'label' => 'Categories',
            ])

            // ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            //     $data = $event->getData();
            //     $form = $event->getForm();
    
            //     // Check if title is set in the submitted data
            //     if (isset($data['title'])) {
            //         // Use Cocur\Slugify\Slugify to generate a slug from the title
            //         $slugify = new Slugify();
            //         $slug = $slugify->slugify($data['title']);
    
            //         // Set the slug field with the generated slug
            //         $data['slug'] = $slug;

            //         $event->setData($data);
            //     }
               
            // })

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
