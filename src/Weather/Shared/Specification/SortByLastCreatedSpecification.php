<?php
declare(strict_types=1);

namespace Shared\Specification;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Pandawa\Component\Ddd\Specification\NameableSpecificationInterface;
use Pandawa\Component\Ddd\Specification\NameableSpecificationTrait;
use Pandawa\Component\Ddd\Specification\SpecificationInterface;

/**
 * @author  Aldi Arief <aldiarief598@gmail.com>
 */
final class SortByLastCreatedSpecification implements SpecificationInterface, NameableSpecificationInterface
{
    use NameableSpecificationTrait;

    /**
     * @param Builder|QueryBuilder $query
     */
    public function match($query): void
    {
        $query->orderBy('created_at', 'DESC');
    }
}