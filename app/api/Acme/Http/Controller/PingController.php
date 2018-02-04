<?php
declare(strict_types=1);

namespace Acme\Api\Http\Controller;

use Pandawa\Module\Api\Transformer\Transformer;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class PingController
{
    public function ping(): Transformer
    {
        return new Transformer(['status' => 'pong']);
    }
}
