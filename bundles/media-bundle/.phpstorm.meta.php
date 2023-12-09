<?php

namespace PHPSTORM_META {
    override(\Interop\Container\ContainerInterface::get(0), map([
        '' => '@',
        'ranky_media' => \Zenchron\FileManagerBundle\Presentation\Twig\MediaTwigService::class,
    ]));
};

