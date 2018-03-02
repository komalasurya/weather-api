<?php
declare(strict_types=1);

namespace App;

use App\Bootstrap\LoadConfiguration;
use Illuminate\Contracts\Foundation\Application;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
trait InjectModuleConfigTrait
{
    public function registerModules(Application $app): void
    {
        $config = $app['config'];
        $config->set('app.providers', array_merge($config->get('app.providers'), $config->get('packages')));
    }

    /**
     * @return Application
     */
    abstract public function getApplication();

    protected function injectModule(): void
    {
        $this->getApplication()->get('events')->listen(
            sprintf('bootstrapped: %s', LoadConfiguration::class),
            [$this, 'registerModules']
        );
    }
}
