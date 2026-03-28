<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

class NotificationMessageData
{
    public function __construct(
        public string $body,
        public string $subject = '',
        public ?string $digest = null,
        public bool $priority = false,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            subject: (string) ($data['subject'] ?? ''),
            digest: $data['digest'] ?? null,
            body: (string) ($data['body'] ?? ''),
            priority: (bool) ($data['priority'] ?? false),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'subject'  => $this->subject,
            'digest'   => $this->digest,
            'body'     => $this->body,
            'priority' => $this->priority,
        ];
    }
}
