<?php
declare(strict_types=1);

namespace Shared\Console\Scout;

use Algolia\AlgoliaSearch\Exceptions\NotFoundException;
use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\SearchIndex;
use Illuminate\Console\Command;
use Shared\Finder\SearchableFinder;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
final class ReImportConsole extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'scout:reimport {searchable? : The name of the searchable}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Reimport the given searchable into the search index';

    /**
     * @var string
     */
    private static $prefix = 'temp';

    /**
     * {@inheritdoc}
     */
    public function handle(
        SearchClient $client,
        SearchableFinder $searchableModelsFinder
    ): void {
        $searchables = $searchableModelsFinder->fromCommand($this);

        $config = config();

        $scoutPrefix = $config->get('scout.prefix');

        $this->output->text('🔎 Importing: <info>['.implode(',', $searchables).']</info>');
        $this->output->newLine();
        $this->output->progressStart(count($searchables) * 3);

        foreach ($searchables as $searchable) {
            $index = $client->initIndex((new $searchable)->searchableAs());
            $temporaryName = $this->getTemporaryIndexName($index);

            tap($this->output)->progressAdvance()->text("Creating temporary index <info>{$temporaryName}</info>");

            try {
                $index->getSettings();

                $client->copyIndex($index->getIndexName(), $temporaryName, [
                    'scope' => [
                        'settings',
                        'synonyms',
                        'rules',
                    ],
                ])->wait();
            } catch (NotFoundException $e) {
                // ..
            }

            tap($this->output)->progressAdvance()->text("Importing records to index <info>{$temporaryName}</info>");

            try {
                $config->set('scout.prefix', self::$prefix.'_'.$scoutPrefix);
                $searchable::makeAllSearchable();
            } finally {
                $config->set('scout.prefix', $scoutPrefix);
            }

            tap($this->output)->progressAdvance()
                ->text("Replacing index <info>{$index->getIndexName()}</info> by index <info>{$temporaryName}</info>");

            $temporaryIndex = $client->initIndex($temporaryName);

            try {
                $temporaryIndex->getSettings();

                $response = $client->moveIndex($temporaryName, $index->getIndexName());

                if ($config->get('scout.synchronous', false)) {
                    $response->wait();
                }
            } catch (NotFoundException $e) {
                $index->setSettings(['attributesForFaceting' => null])->wait();
            }
        }

        tap($this->output)->success('All ['.implode(',', $searchables).'] records have been imported')->newLine();
    }

    /**
     * Get a temporary index name.
     *
     * @param \Algolia\AlgoliaSearch\SearchIndex $index
     *
     * @return string
     */
    private function getTemporaryIndexName(SearchIndex $index): string
    {
        return self::$prefix.'_'.$index->getIndexName();
    }
}
