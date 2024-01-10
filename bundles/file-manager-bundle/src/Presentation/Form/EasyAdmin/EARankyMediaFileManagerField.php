<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Presentation\Form\EasyAdmin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Zenchron\FileBundle\Presentation\Form\RankyMediaFileManagerType;

if (\interface_exists('EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface')) {
    final class EARankyMediaFileManagerField implements FieldInterface
    {
        use FieldTrait;

        public const        OPTION_MULTIPLE_SELECTION = 'multiple_selection';
        public const        OPTION_ASSOCIATION        = 'association';
        public const        OPTION_MODAL_TITLE        = 'modal_title';

        public static function new(string $propertyName, $label = null): self
        {
            return (new self())
                ->setProperty($propertyName)
                ->setLabel($label)
                ->addWebpackEncoreEntries(
                    Asset::new('zenchron_file')
                        ->webpackEntrypointName('zenchron_file')
                )
                ->setFormType(RankyMediaFileManagerType::class)
                ->setFormTypeOptions([
                    self::OPTION_MULTIPLE_SELECTION => false,
                    self::OPTION_ASSOCIATION        => false,
                    self::OPTION_MODAL_TITLE        => 'Media File Manager',
                ])
                ->addFormTheme('@ZenchronFile/form.html.twig')
                ->setTemplatePath('@ZenchronFile/preview/easyadmin.html.twig')
                ->setSortable(false);
        }

        public function multipleSelection(bool $isMultiple = true): self
        {
            $this->setFormTypeOption(self::OPTION_MULTIPLE_SELECTION, $isMultiple);

            return $this;
        }

        public function association(bool $isAssociation = true): self
        {
            $this->setFormTypeOption(self::OPTION_ASSOCIATION, $isAssociation);

            return $this;
        }

        public function modalTitle(string $modalTitle): self
        {
            $this->setFormTypeOption(self::OPTION_MODAL_TITLE, $modalTitle);

            return $this;
        }
    }
}
