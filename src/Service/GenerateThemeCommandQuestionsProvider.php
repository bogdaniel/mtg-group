<?php
declare(strict_types=1);

namespace App\Service;

class GenerateThemeCommandQuestionsProvider
{
    public function getQuestions(): array
    {
        return [
            'title' => [
                'question' => 'Please enter the title of the theme: ',
                'validator' => 'validateTitle',
            ],
            'packageName' => [
                'question' => 'Please enter the package name of the theme: ',
                'validator' => 'validatePackageName',
            ],
            'description' => [
                'question' => 'Please enter the description of the theme: ',
                'validator' => 'validateDescription',
            ],
            'license' => [
                'question' => 'Please enter the license of the theme: ',
                'validator' => 'validateLicense',
            ],
            'homepage' => [
                'question' => 'Please enter the homepage of the theme: ',
                'validator' => 'validateHomepage',
            ],
            'version' => [
                'question' => 'Please enter the version of the theme: ',
                'validator' => 'validateVersion',
            ],
            'authors' => [
                'question' => 'Please enter the author of the theme (leave empty to stop): ',
                'validator' => null,
                'multiple' => true,
                'subQuestions' => [
                    'email' => [
                        'question' => 'Please enter the email of the author: ',
                        'validator' => 'validateAuthorEmail',
                    ],
                ],
            ]
        ];
    }
}
