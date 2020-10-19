<?php
declare(strict_types=1);

namespace Shared\Specification;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Pandawa\Component\Ddd\Specification\SpecificationInterface;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
abstract class AbstractSortSpecification implements SpecificationInterface
{
    /**
     * @var null|string
     */
    protected $sort;

    /**
     * @var null|string
     */
    protected $order;

    /**
     * AbstractSortSpecification constructor.
     * @param string|null $sort
     * @param string|null $order
     */
    public function __construct(?string $sort, ?string $order)
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    /**
     * @param Builder|QueryBuilder $query
     */
    public function match($query): void
    {
        if ($this->sort && in_array($this->sort, $this->allowedColumns(), true)) {
            $sort = $this->sort;
        }

        if ('asc' === $this->order) {
            $order = 'asc';
        } else {
            $order = 'desc';
        }

        if (isset($sort) && isset($order)) {
            $query->orderBy(sprintf('%s.%s', $this->modelTable(), $sort), $order);
        }
    }

    /**
     * @return string
     */
    protected abstract function modelTable(): string ;

    /**
     * @return array
     */
    protected abstract function allowedColumns(): array ;
}