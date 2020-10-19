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
final class FilterByNameSpecification implements SpecificationInterface, NameableSpecificationInterface
{
    use NameableSpecificationTrait;

    /**
     * @var null|string
     */
    private $keyword;

    /**
     * FilterByNameSpecification constructor.
     * @param string|null $keyword
     */
    public function __construct(?string $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @param Builder|QueryBuilder $query
     */
    public function match($query): void
    {
        if ($this->keyword) {
            $query->where('name', 'ilike', '%' . $this->keyword . '%');
        }
    }
}