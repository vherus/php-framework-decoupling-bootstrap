<?php

namespace Vherus\Framework\Jsend;

use JsonSerializable;

class JsendError implements JsonSerializable
{
    private $message;
    private $code;

    public function __construct(string $message, int $code = 1)
    {
        $this->message = $message;
        $this->code = $code;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function jsonSerialize(): object
    {
        return (object) [
            'message' => $this->message,
            'code' => $this->code
        ];
    }
}
