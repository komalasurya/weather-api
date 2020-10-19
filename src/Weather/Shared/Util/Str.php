<?php
declare(strict_types=1);

namespace Shared\Util;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Str
{
    public static function key($text): string
    {
        $string = str_replace(' ', '-', strtolower(trim($text)));

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}
