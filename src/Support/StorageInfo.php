<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Support;

class StorageInfo
{
    /** @var Mount[] */
    public array $mounts = [];

    public function __construct(protected array $storageSpace)
    {
        for ($i = 0; $i < count($storageSpace); $i += 2) {
            $this->mounts[] = new Mount($storageSpace[$i], $storageSpace[$i + 1]);
        }
    }

    public function all(): array
    {
        return $this->mounts;
    }

    public function formatted(): array
    {
        return array_map(function (Mount $mount) {
            return [
                'free'         => $mount->freeFormatted(),
                'total'        => $mount->totalFormatted(),
                'used'         => $mount->usedFormatted(),
                'free_percent' => $mount->freePercent().'%',
            ];
        }, $this->mounts);
    }

    public function toArray(): array
    {
        $values = [];

        foreach ($this->mounts as $mount) {
            $values[] = $mount->free;
            $values[] = $mount->total;
        }

        return $values;
    }
}
