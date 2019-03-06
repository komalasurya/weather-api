<?php
declare(strict_types=1);

namespace Acme\Web\Presenter;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Pandawa\Component\Presenter\NameablePresenterInterface;
use Pandawa\Component\Presenter\NameablePresenterTrait;
use Pandawa\Component\Presenter\PresenterInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class LandingPresenter implements PresenterInterface, NameablePresenterInterface
{
    use NameablePresenterTrait;

    /**
     * @param Request $request
     *
     * @return View|Responsable
     */
    public function render(Request $request)
    {
        return view('acme-web::pages.landing');
    }
}
