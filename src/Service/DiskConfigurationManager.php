class DiskConfigurationManager
{
    private DiskRepository $diskRepository;

    public function __construct(DiskRepository $diskRepository)
    {
        $this->diskRepository = $diskRepository;
    }

    public function create(DiskConfiguration $diskConfiguration): void
    {
        $this->diskRepository->create($diskConfiguration);
    }

    public function read(int $id): ?DiskConfiguration
    {
        return $this->diskRepository->read($id);
    }

    public function update(DiskConfiguration $diskConfiguration): void
    {
        $this->diskRepository->update($diskConfiguration);
    }

    public function delete(DiskConfiguration $diskConfiguration): void
    {
        $this->diskRepository->delete($diskConfiguration);
    }
}
