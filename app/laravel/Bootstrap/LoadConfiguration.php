<?php
/**
 * This file is part of the Pandawa Skeleton package.
 *
 * (c) 2018 Pandawa <https://github.com/bl4ckbon3/pandawa>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Bootstrap;

use Illuminate\Foundation\Bootstrap\LoadConfiguration as LaravelLoadConfiguration;
use Illuminate\Contracts\Config\Repository as RepositoryContract;
use Illuminate\Contracts\Foundation\Application;
use Pandawa\Component\Loader\ChainLoader;
use Symfony\Component\Finder\Finder;
use Exception;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class LoadConfiguration extends LaravelLoadConfiguration
{
    /**
     * @var ChainLoader
     */
    protected $loader;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loader = ChainLoader::create();
    }

    /**
     * {@inheritdoc}
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($app);

        if (! isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, $this->loader->load($path));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];

        $configPath = realpath($app->configPath());

        foreach (Finder::create()->files()->in($configPath) as $file) {
            if (!$this->loader->supports($file->getRealPath())) {
                continue;
            }

            $directory = $this->getNestedDirectory($file, $configPath);
            $extension = pathinfo($file->getRealPath(), PATHINFO_EXTENSION);

            $files[$directory.basename($file->getRealPath(), '.' . $extension)] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }
}
