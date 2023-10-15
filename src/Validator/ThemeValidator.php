<?php

namespace App\Validator;

class GenerateThemeCommandValidator
{
    public function validateTitle($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The title of the theme is required.');
        }

        return $answer;
    }

    public function validatePackageName($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The package name of the theme is required.');
        }
        if (!preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*\/[a-z0-9]+(?:-[a-z0-9]+)*$/', $answer)) {
            throw new \RuntimeException('The package name should be a valid composer package name.');
        }

        return strtolower($answer);
    }

    public function validateDescription($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The description of the theme is required.');
        }

        return $answer;
    }

    public function validateLicense($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The license of the theme is required.');
        }

        return $answer;
    }

    public function validateHomepage($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The homepage of the theme is required.');
        }

        return $answer;
    }

    public function validateAuthorEmail($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The email of the author is required.');
        }
        if (!filter_var($answer, FILTER_VALIDATE_EMAIL)) {
            throw new \RuntimeException('The email should be a valid email address.');
        }

        return $answer;
    }

    public function validateVersion($answer): string
    {
        if (empty($answer)) {
            throw new \RuntimeException('The version of the theme is required.');
        }
        if (!preg_match('/^(\d+\.)?(\d+\.)?(\*|\d+)$/', $answer)) {
            throw new \RuntimeException('The version should follow semantic versioning.');
        }

        return $answer;
    }
}
