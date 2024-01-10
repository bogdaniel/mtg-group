<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Presentation\BackOffice;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zenchron/media/embed', name: 'zenchron_file_embed', methods: ['GET'], priority: 5)]
class EmbedMediaBackOfficeController extends BaseMediaBackOfficeController
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(Request $request): Response
    {
        return $this->render(
            '@ZenchronFile/embed.html.twig',
            [
                'title' => $this->trans('title'),
            ]
        );
    }

}
