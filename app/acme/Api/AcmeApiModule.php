<?php
declare(strict_types=1);

namespace Acme\Api;

use Pandawa\Component\Module\AbstractModule;
use Pandawa\Component\Module\Provider\RouteProviderTrait;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class AcmeApiModule extends AbstractModule
{
    use RouteProviderTrait;

    protected function routes(): array
    {
        return [
            [
                'type'       => 'group',
                'middleware' => 'api',
                'prefix'     => 'api/v{version}',
                'children'   => $this->getCurrentPath() . '/Resources/routes/routes.yaml',
            ],
        ];
    }
}
