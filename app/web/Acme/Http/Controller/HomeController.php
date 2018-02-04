<?php
declare(strict_types=1);

namespace Acme\Web\Http\Controller;

use Illuminate\Contracts\View\View;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class HomeController
{
    public function index(): View
    {
        return view('welcome');
    }
}
