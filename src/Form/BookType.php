<?php

namespace App\Form;

use App\Entity\Genres;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Date;

class BookType extends AbstractType
{
    protected $selectedEntities;
    protected $entities;

    public function __construct($entities = null, $selectedEntities = null)
    {
        $this->entities = $entities;
        $this->selectedEntities = $selectedEntities;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // creates a task and gives it some dummy data for this example

//dd($options['genre_list']);
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Название книги'

            ))
            ->add('cover', FileType::class,array(
                'label' => 'Изображение',
                'required' => $options['cover_required'],
                'data_class' => null
            ))
            ->add('book_pdf', FileType::class,array(
                'label' => 'Книга pdf',
                'required' => $options['cover_required'],
                'data_class' => null
            ))
            ->add('number_pages', TextType::class,array(
                'label' => 'Количество страниц'
            ))
            ->add('date', DateType::class,array(
                'label' => 'Дата издания',
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ))
            ->add('description', TextareaType::class ,array(
                'label' => 'Описание'
            ))
            ->add('writer', EntityType::class, array(
                'class'    => 'App\Entity\Writers',
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'label' => 'Писатель',

            ))
                ->add('select_genre', EntityType::class, array(
                'class'    => Genres::class,
                'choice_label' => 'title',
                'required' => true,
                'multiple' => true,
                'mapped' => false,
                'label' => 'Жанр',
               // 'choices'=>array(0=>32,1=>'4334'),
                /*'query_builder' => function(EntityRepository $er)
                {
                    return $er->createQueryBuilder('s')->orderBy('s.title', 'ASC');
                },*/

                'data'=>$options['selected_genre'],
            ))
            ->add('save', SubmitType::class, ['label' => 'Добавить книгу'])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Book::class,
            'genre_list' => null,
            'cover_required'=>true,
            'selected_genre'=>array(1),
        ));
    }
}