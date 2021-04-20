<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,  ['label' => 'Email'])
            ->add('pseudo', TextType::class, ['label' => 'Pseudo'])
            ->add('website',  UrlType::class, ['required' => false , 'label' => 'Site web'])
            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])
            ->add('content', TextType::class,  ['label' => 'Contenu']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
