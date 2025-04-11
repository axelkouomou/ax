<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Folder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType as DocumentType;
use Symfony\Component\Validator\Constraints\File as Doc;


class FileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('folder', EntityType::class, [
                'class' => Folder::class,
                'choice_label' => 'name'
                
            ])

            ->add('file', DocumentType::class, [
                'label' => 'Choisir un fichier',
                'mapped' => false, // Le fichier n'est pas directement mappé à l'entité
                'required' => true,
                'constraints' => [
                    new Doc([
                        'maxSize' => '10M', // 🔹 Limite fixée ici (10 mégaoctets)
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). La taille maximale autorisée est de {{ limit }} {{ suffix }}.',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/docx',
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Format de fichier non autorisé.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => File::class,
            'csrf_protection'   => false
        ]);
    }
}


