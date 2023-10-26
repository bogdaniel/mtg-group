<?php

namespace App\Service;

use Symfony\Component\Form\FormFactoryInterface;

class FormBuilderService
{
    private FormBuilderConfigurationReader $configReader;
    private FormFactoryInterface $formFactory;

    public function __construct(FormBuilderConfigurationReader $configReader, FormFactoryInterface $formFactory)
    {
        $this->configReader = $configReader;
        $this->formFactory = $formFactory;
    }

    public function buildForms(): array
    {
        $config = $this->configReader->parse();
        $forms = [];

        foreach ($config['forms'] as $formName => $formConfig) {
            $form = $this->formFactory->createNamed($formName, $formConfig['type'], null, $formConfig['options']);
            $forms[$formName] = $form;
        }

        return $forms;
    }
}
