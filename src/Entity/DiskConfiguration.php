class DiskConfiguration
{
    private DiskConfigurationData $diskConfigurationData;

    public function __construct(DiskConfigurationData $diskConfigurationData)
    {
        $this->diskConfigurationData = $diskConfigurationData;
    }

    public function getId(): ?int
    {
        return $this->diskConfigurationData->getId();
    }

    public function getConfiguration(): array
    {
        return $this->diskConfigurationData->getConfiguration();
    }
}
