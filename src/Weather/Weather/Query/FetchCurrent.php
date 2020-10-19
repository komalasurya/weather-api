<?php
declare(strict_types=1);

namespace Weather\Weather\Query;

use Pandawa\Component\Message\AbstractCommand;
use Pandawa\Component\Message\NameableMessageInterface;
use Pandawa\Component\Support\NameableClassTrait;

/**
 * Class FetchCurrent
 * @author Komala Surya <komala.surya.w@gmail.com>
 */
class FetchCurrent extends AbstractCommand implements NameableMessageInterface
{
    use NameableClassTrait;

    /** @var string */
    private $lat;

    /** @var string */
    private $lon;

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLon(): string
    {
        return $this->lon;
    }
}