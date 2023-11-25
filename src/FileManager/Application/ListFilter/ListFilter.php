<?php
declare(strict_types=1);

namespace App\FileManager\Application\ListFilter;


use App\FileManager\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilterResponse;
use App\FileManager\Application\ListFilter\ListMimeFilter\ListMimeFilter;
use App\FileManager\Application\ListFilter\ListAvailableDatesFilter\ListAvailableDatesFilter;
use App\FileManager\Application\ListFilter\ListMimeFilter\ListMimeFilterResponse;
use App\FileManager\Application\ListFilter\ListUserFilter\ListUserFilter;
use App\FileManager\Application\ListFilter\ListUserFilter\ListUserFilterResponse;

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
