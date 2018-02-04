<?php
declare(strict_types=1);

namespace Acme\Api;

use App\Routing\RouteProviderTrait;
use Pandawa\Component\Module\AbstractModule;

/**
 * @mixin \Illuminate\Routing\Router
 *
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class AcmeApiModule extends AbstractModule
{
    use RouteProviderTrait;

    /**
     * {@inheritdoc}
     */
    public function boot(): void
    {
        parent::boot();

        $this->bootRoute();
    }

    protected function routes(): array
    {
        return [
            [
                'type'       => 'group',
                'middleware' => 'api',
                'prefix'     => 'v{version}',
                'children'   => $this->getCurrentPath() . '/Resources/routes/routes.php',
            ],
        ];
    }
}
