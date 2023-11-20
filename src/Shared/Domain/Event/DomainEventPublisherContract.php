<?php
declare(strict_types=1);

namespace App\Shared\Domain\Event;

/**
 * EventBus or EventDispatcher or EventPublisher
 */
interface DomainEventPublisherContract
{

    /** @return DomainEventSubscriber[] */
    public function getSubscribers(): array;

    public function addSubscriber(DomainEventSubscriber $domainEventSubscriber): void;

    public function removeSubscriber(DomainEventSubscriber $domainEventSubscriber): void;

    /**
     * Publish subscribers by Domain Event
     *
     * ```
     * $this->domainEventPublisher->publish(...$domain->recordedEvents())
     * ```
     *
     * @param DomainEvent ...$domainEvents
     * @return void
     */
    public function publish(DomainEvent ...$domainEvents): void;
}
