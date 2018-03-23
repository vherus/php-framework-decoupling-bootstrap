<?php

namespace Vherus\Framework\Jsend;

use InvalidArgumentException;

class JsendSuccessResponse extends JsendResponse
{
    /** @throws InvalidArgumentException */
    public function __construct($data = null, array $headers = [], $encodingOptions = self::DEFAULT_JSON_FLAGS)
    {
        parent::__construct($data, 'success', $headers, $encodingOptions);
    }
}
