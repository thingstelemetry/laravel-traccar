<?php

declare(strict_types=1);

namespace TrackTelemetry\Traccar\Dto;

class DeviceAttributesData
{
    public function __construct(
        public ?float $speedLimit = null,
        public ?float $fuelDropThreshold = null,
        public ?float $fuelIncreaseThreshold = null,
        public bool $reportIgnoreOdometer = false,
        public ?float $deviceInactivityStart = null,
        public ?float $deviceInactivityPeriod = null,
        public ?string $notificationTokens = null,
        public ?string $commandSender = null,
        public ?string $webReportColor = null,
        public ?string $devicePassword = null,
        public ?string $deviceImage = null,
        public ?string $processingCopyAttributes = null,
        public ?string $decoderTimezone = null,
        public ?string $forwardUrl = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            speedLimit: $data['speedLimit'] ?? null,
            fuelDropThreshold: $data['fuelDropThreshold'] ?? null,
            fuelIncreaseThreshold: $data['fuelIncreaseThreshold'] ?? null,
            reportIgnoreOdometer: $data['report.ignoreOdometer'] ?? false,
            deviceInactivityStart: $data['deviceInactivityStart'] ?? null,
            deviceInactivityPeriod: $data['deviceInactivityPeriod'] ?? null,
            notificationTokens: $data['notificationTokens'] ?? null,
            commandSender: $data['command.sender'] ?? null,
            webReportColor: $data['web.reportColor'] ?? null,
            devicePassword: $data['devicePassword'] ?? null,
            deviceImage: $data['deviceImage'] ?? null,
            processingCopyAttributes: $data['processing.copyAttributes'] ?? null,
            decoderTimezone: $data['decoder.timezone'] ?? null,
            forwardUrl: $data['forward.url'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'speedLimit'                => $this->speedLimit,
            'fuelDropThreshold'         => $this->fuelDropThreshold,
            'fuelIncreaseThreshold'     => $this->fuelIncreaseThreshold,
            'report.ignoreOdometer'     => $this->reportIgnoreOdometer,
            'deviceInactivityStart'     => $this->deviceInactivityStart,
            'deviceInactivityPeriod'    => $this->deviceInactivityPeriod,
            'notificationTokens'        => $this->notificationTokens,
            'command.sender'            => $this->commandSender,
            'web.reportColor'           => $this->webReportColor,
            'devicePassword'            => $this->devicePassword,
            'deviceImage'               => $this->deviceImage,
            'processing.copyAttributes' => $this->processingCopyAttributes,
            'decoder.timezone'          => $this->decoderTimezone,
            'forward.url'               => $this->forwardUrl,
        ];
    }
}