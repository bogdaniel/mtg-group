<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\ListFilter;


use Zenchron\FileBundle\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilterResponse;
use Zenchron\FileBundle\Application\ListFilter\ListMimeFilter\ListMimeFilter;
use Zenchron\FileBundle\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilter;
use Zenchron\FileBundle\Application\ListFilter\ListMimeFilter\ListMimeFilterResponse;
use Zenchron\FileBundle\Application\ListFilter\ListUserFilter\ListUserFilter;
use Zenchron\FileBundle\Application\ListFilter\ListUserFilter\ListUserFilterResponse;

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
