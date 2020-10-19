<?php
declare(strict_types=1);

namespace Shared\Console\Scout;

use Algolia\ScoutExtended\Searchable\ObjectIdEncrypter;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Collection;
use Laravel\Scout\Events\ModelsImported;
use Shared\Finder\SearchableFinder;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class ImportConsole extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'scout:import {searchable? : The name of the searchable}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Import the given searchable into the search index';

    /**
     * {@inheritdoc}
     */
    public function handle(Dispatcher $events, SearchableFinder $searchableFinder): void
    {
        foreach ($searchableFinder->fromCommand($this) as $searchable) {
            $this->call('scout:flush', ['searchable' => $searchable]);

            $events->listen(ModelsImported::class, function ($event) use ($searchable) {
                $this->resultMessage($event->models, $searchable);
            });

            $searchable::makeAllSearchable();

            $events->forget(ModelsImported::class);

            $this->output->success('All ['.$searchable.'] records have been imported.');
        }
    }

    /**
     * Prints last imported object ID to console output, if any.
     *
     * @param \Illuminate\Support\Collection $models
     * @param string $searchable
     *
     * @return void
     */
    private function resultMessage(Collection $models, string $searchable): void
    {
        if ($models->count() > 0) {
            $last = ObjectIdEncrypter::encrypt($models->last());

            $this->line('<comment>Imported ['.$searchable.'] models up to ID:</comment> '.$last);
        }
    }
}
