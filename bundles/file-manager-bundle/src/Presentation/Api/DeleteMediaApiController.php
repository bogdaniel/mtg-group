<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Presentation\Api;


use Zenchron\FileBundle\Application\DeleteMedia\DeleteMedia;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\FileBundle\Infrastructure\Event\DeleteEvent;
use Zenchron\SharedBundle\Domain\Exception\ApiProblem\ApiProblemException;
use Zenchron\SharedBundle\Domain\Exception\ApiProblem\CouldNotFindRequestValueException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


#[Route('/zenchron/dashboard/{id}', name: 'zenchron_file_delete', requirements: ['id' => '[0-7][0-9A-HJKMNP-TV-Z]{25}'], methods: ['DELETE'], priority: 2)]
class DeleteMediaApiController extends BaseMediaApiController
{

    public function __construct(
        private readonly DeleteMedia $deleteMedia,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(string $id = null): JsonResponse
    {
        if (null === $id) {
            throw new CouldNotFindRequestValueException('Id');
        }

        try {
            $this->eventDispatcher->dispatch(
                new DeleteEvent(MediaId::fromString($id)),
                DeleteEvent::PRE_DELETE
            );
            $this->deleteMedia->__invoke($id);
            $this->eventDispatcher->dispatch(
                new DeleteEvent(MediaId::fromString($id)),
                DeleteEvent::POST_DELETE
            );
        } catch (\Throwable $throwable) {
            throw ApiProblemException::fromThrowable($throwable);
        }

        return $this->json(['message' => $this->trans('on_remove')], Response::HTTP_OK);
    }

}
