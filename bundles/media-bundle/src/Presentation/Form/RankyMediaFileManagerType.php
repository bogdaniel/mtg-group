<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Presentation\Form;

use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Presentation\Form\DataTransformer\JsonToArrayTransformer;
use Zenchron\FileManagerBundle\Presentation\Form\DataTransformer\MediaCollectionTransformer;
use Zenchron\FileManagerBundle\Presentation\Form\DataTransformer\MediaEntityTransformer;
use Zenchron\FileManagerBundle\Presentation\Form\DataTransformer\MediaIdToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RankyMediaFileManagerType extends AbstractType
{

    public function __construct(private readonly MediaRepositoryInterface $mediaRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['association'] === true) {
            if ($options['multiple_selection'] === true) {
                $builder->addModelTransformer(new MediaCollectionTransformer($this->mediaRepository));
            } else {
                $builder->addModelTransformer(new MediaEntityTransformer($this->mediaRepository));
            }
        } elseif ($options['multiple_selection'] === true) {
            $builder->addModelTransformer(new JsonToArrayTransformer());
        } else {
            $builder->addViewTransformer(new MediaIdToStringTransformer());
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => false,
            'multiple_selection' => false,
            'modal_title' => 'Media File Manager',
            'association' => false,
            'api_prefix' => null,
        ]);


        $resolver->setAllowedTypes('multiple_selection', 'bool');
        $resolver->setAllowedTypes('association', 'bool');
        $resolver->setAllowedTypes('modal_title', 'string');
        $resolver->setAllowedTypes('api_prefix', ['string', 'null']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars = \array_replace($view->vars, [
            'multiple_selection' => $options['multiple_selection'],
            'api_prefix' => $options['api_prefix'],
            'modal_title' => $options['modal_title'],
            'association' => $options['association'],
        ]);
    }


    public function getParent(): string
    {
        return HiddenType::class;
    }


    public function getBlockPrefix(): string
    {
        return 'ranky_media_file_manager';
    }
}
