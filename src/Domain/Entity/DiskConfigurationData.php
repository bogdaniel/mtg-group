class DiskConfigurationData implements DiskConfigurationContract
{
    private ?int $id;
    private array $configuration;

    public function __construct(?int $id, array $configuration)
    {
        $this->id = $id;
        $this->configuration = $configuration;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
