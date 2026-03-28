<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Dto\StatusData;
use ThingsTelemetry\Traccar\Requests\Password\ResetPassword;
use ThingsTelemetry\Traccar\Requests\Password\UpdatePassword;

class Password extends Traccar
{
    /**
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function reset(string $email): StatusData
    {
        $response = $this->connector->send(request: new ResetPassword(email: $email));

        return $response->dtoOrFail();
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function update(string $token, string $password): StatusData
    {
        $response = $this->connector->send(request: new UpdatePassword(token: $token, password: $password));

        return $response->dtoOrFail();
    }
}
