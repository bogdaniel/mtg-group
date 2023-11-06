<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    // Add common methods for controllers here

    protected function handleFormSubmission(FormInterface $form, callable $onSuccess): callable
    {
        return function (Request $request) use ($form, $onSuccess) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                return $onSuccess($form->getData());
            }

            return null;
        };
    }
}
