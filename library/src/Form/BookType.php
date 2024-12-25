<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название ',
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255)
                ],
            ])
            ->add('author', TextType::class, [
                'label' => 'Автор ',
                'constraints' => [
                    new NotBlank(),
                    new Length(max: 255)
                ],
            ])
            ->add('cover', FileType::class, [
                'label' => 'Обложка ',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new Image(maxSize: '5M', mimeTypes: ['image/png', 'image/jpeg'])
                ],
            ])
            ->add('file', FileType::class, [
                'label' => 'Файл с книгой ',
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new File(maxSize: '5M', extensions: ['pdf'])
                ],
            ])
            ->add('readAt', DateTimeType::class, [
                'widget' => 'single_text',
                //'html5' => false,
                //'format' => 'dd.MM.yyyy',
                'label' => 'Дата прочтения '
            ])
            ->add('uploadable', null, [
                'label' => 'Разрешить скачивание '
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Добавить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
