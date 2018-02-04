<?php
declare(strict_types=1);

namespace Acme\Web;

use App\Routing\RouteProviderTrait;
use Pandawa\Component\Module\AbstractModule;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class AcmeWebModule extends AbstractModule
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
                'children'   => $this->getCurrentPath() . '/Resources/routes/routes.php',
            ],
        ];
    }
}
