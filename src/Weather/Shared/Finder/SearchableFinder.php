<?php
declare(strict_types=1);

namespace Shared\Finder;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Laravel\Scout\Searchable;
use Pandawa\Component\Resource\ResourceRegistryInterface;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class SearchableFinder
{
    /**
     * @var array
     */
    private static $declaredClasses;

    /**
     * @var Application
     */
    private $app;

    /**
     * SearchableModelsFinder constructor.
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get a list of searchable models from the given command.
     *
     * @param \Illuminate\Console\Command $command
     *
     * @return array
     */
    public function fromCommand(Command $command): array
    {
        $searchables = (array) $command->argument('searchable');

        if (empty($searchables) && empty($searchables = $this->find())) {
            throw new InvalidArgumentException('No searchable classes found.');
        }

        return $searchables;
    }

    /**
     * Get a list of searchable models.
     *
     * @return string[]
     */
    public function find(): array
    {
        return array_values(array_filter($this->getResourceClasses(), function (string $class) {
            return $this->isSearchableModel($class);
        }));
    }

    /**
     * @param  string $class
     *
     * @return bool
     */
    private function isSearchableModel($class): bool
    {
        return in_array(Searchable::class, class_uses_recursive($class), true);
    }

    /**
     * @return array
     */
    private function getResourceClasses(): array
    {
        /** @var ResourceRegistryInterface $registry */
        $registry = $this->app->get(ResourceRegistryInterface::class);

        $fn = Closure::bind(function () {
            return array_values(array_map(function (array $meta) {
                return $meta['model_class'];
            }, $this->resources));
        }, $registry, get_class($registry));

        return $fn();
    }
}
