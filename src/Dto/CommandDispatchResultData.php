<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Dto;

use Illuminate\Support\Collection;

class CommandDispatchResultData
{
    /**
     * @param  Collection<int, QueuedCommandData>  $queuedCommands
     */
    public function __construct(
        public ?CommandData $sentCommand,
        public Collection $queuedCommands,
    ) {
    }

    public static function fromArray(array $data): self
    {
        if (array_is_list($data)) {
            return new self(
                sentCommand: null,
                queuedCommands: collect($data)
                    ->map(callback: fn (array $command) => QueuedCommandData::fromArray(data: $command)),
            );
        }

        if (array_key_exists('description', $data)) {
            return new self(
                sentCommand: CommandData::fromArray(data: $data),
                queuedCommands: collect(),
            );
        }

        return new self(
            sentCommand: null,
            queuedCommands: collect([
                QueuedCommandData::fromArray(data: $data),
            ]),
        );
    }
}
