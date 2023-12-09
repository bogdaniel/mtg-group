<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\ListFilter;


use Zenchron\FileManagerBundle\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilterResponse;
use Zenchron\FileManagerBundle\Application\ListFilter\ListMimeFilter\ListMimeFilter;
use Zenchron\FileManagerBundle\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilter;
use Zenchron\FileManagerBundle\Application\ListFilter\ListMimeFilter\ListMimeFilterResponse;
use Zenchron\FileManagerBundle\Application\ListFilter\ListUserFilter\ListUserFilter;
use Zenchron\FileManagerBundle\Application\ListFilter\ListUserFilter\ListUserFilterResponse;

class ListFilter
{
    public function __construct(
        private readonly ListAvailableDatesFilter $listAvailableDatesFilter,
        private readonly ListMimeFilter $listMimeFilter,
        private readonly ListUserFilter $listUserFilter
    ) {
    }

    /**
     * @return array{availableDates: array<ListAvailableDatesFilterResponse>, mimeTypes: array<ListMimeFilterResponse>, users: array<ListUserFilterResponse> }
     */
    public function __invoke(): array
    {
        return [
            'availableDates' => $this->listAvailableDatesFilter->__invoke(),
            'mimeTypes' => $this->listMimeFilter->__invoke(),
            'users' => $this->listUserFilter->__invoke(),
        ];
    }
}
