<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Localization
{
    /**
     * @var Application
     */
    private $app;

    /**
     * Constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Content-Language', $this->app->config->get('app.fallback_locale'));

        if (!array_key_exists($locale, $this->app->config->get('app.supported_locales'))) {
            throw new Exception('Language not supported', 403);
        }

        $this->app->setLocale($locale);

        $response = $next($request);

        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
