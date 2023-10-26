<?php

namespace App\Service;

use App\Domain\Contract\DiskConfigurationDataContract;
use App\Repository\DiskRepository;

class DiskConfigurationManager
{
    private DiskRepository $diskRepository;

    public function __construct(DiskRepository $diskRepository)
    {
        $this->diskRepository = $diskRepository;
    }

    public function create(DiskConfigurationDataContract $diskConfiguration): void
    {
        $this->diskRepository->create($diskConfiguration);
    }

    public function read(int $id): ?DiskConfigurationDataContract
    {
        return $this->diskRepository->read($id);
    }

    public function update(DiskConfigurationDataContract $diskConfiguration): void
    {
        $this->diskRepository->update($diskConfiguration);
    }

    public function delete(DiskConfigurationDataContract $diskConfiguration): void
    {
        $this->diskRepository->delete($diskConfiguration);
    }
}
