<?php

namespace Vherus\Framework\IO;

use Closure;

class OutputBuffer
{
    public static function capture(Closure $callback): string
    {
        ob_start();

        $callback();

        $content = ob_get_contents();

        ob_end_clean();

        return $content;
    }
}
