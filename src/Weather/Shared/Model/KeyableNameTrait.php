<?php
declare(strict_types=1);

namespace Shared\Model;

use Shared\Util\Str;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
trait KeyableNameTrait
{
    /**
     * @param string $name
     */
    protected function setNameAttribute(string $name): void
    {
        $this->attributes['name'] = trim($name);
        $this->attributes['key'] = Str::key($this->attributes['name']);
    }
}
