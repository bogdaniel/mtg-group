<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    // Add common methods for controllers here

    protected function handleFormSubmission(FormInterface $form, callable $onSuccess): callable
    {
        return static function (Request $request) use ($form, $onSuccess) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                return $onSuccess($form->getData());
            }

            return null;
        };
    }
}
