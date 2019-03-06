<?php
declare(strict_types=1);

namespace Acme\Api\Presenter;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pandawa\Component\Presenter\NameablePresenterInterface;
use Pandawa\Component\Presenter\NameablePresenterTrait;
use Pandawa\Component\Presenter\PresenterInterface;
use Pandawa\Module\Api\Http\Controller\InteractsWithRendererTrait;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class PingPresenter implements PresenterInterface, NameablePresenterInterface
{
    use NameablePresenterTrait;
    use InteractsWithRendererTrait {
        InteractsWithRendererTrait::render as response;
    }

    /**
     * @param Request $request
     *
     * @return View|Responsable
     */
    public function render(Request $request)
    {
        return $this->response($request, ['status' => 'pong']);
    }
}
