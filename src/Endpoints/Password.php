<?php

declare(strict_types=1);

namespace ThingsTelemetry\Traccar\Endpoints;

use Saloon\Http\Response;
use ThingsTelemetry\Traccar\Traccar;
use ThingsTelemetry\Traccar\Requests\Password\ResetPassword;
use ThingsTelemetry\Traccar\Requests\Password\UpdatePassword;

class Password extends Traccar
{
    /**
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function reset(string $email): Response
    {
        return $this->connector->send(request: new ResetPassword(email: $email));
    }

    /**
     * @throws \Saloon\Exceptions\SaloonException
     */
    public function update(string $token, string $password): Response
    {
        return $this->connector->send(request: new UpdatePassword(token: $token, password: $password));
    }
}
