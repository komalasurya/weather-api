<?php
declare(strict_types=1);

namespace Acme\Web;

use Pandawa\Component\Module\AbstractModule;
use Pandawa\Component\Module\Provider\RouteProviderTrait;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class AcmeWebModule extends AbstractModule
{
    use RouteProviderTrait;

    protected function routes(): array
    {
        return [
            [
                'type'       => 'group',
                'children'   => $this->getCurrentPath() . '/Resources/routes/routes.yaml',
            ],
        ];
    }
}
