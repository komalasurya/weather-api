<?php
declare(strict_types=1);

namespace Acme\Api\Http\Controller;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Pandawa\Module\Api\Http\Controller\InteractsWithRendererTrait;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class PingController
{
    use InteractsWithRendererTrait;

    public function ping(Request $request): Responsable
    {
        return $this->render($request, ['status' => 'pong']);
    }
}
