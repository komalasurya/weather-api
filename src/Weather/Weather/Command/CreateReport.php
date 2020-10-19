<?php
declare(strict_types=1);

namespace Weather\Weather\Command;

use Illuminate\Http\UploadedFile;
use Pandawa\Component\Message\AbstractCommand;
use Pandawa\Component\Message\NameableMessageInterface;
use Pandawa\Component\Support\NameableClassTrait;

/**
 * Class CreateReport
 * @author Komala Surya <komala.surya.w@gmail.com>
 */
class CreateReport extends AbstractCommand implements NameableMessageInterface
{
    use NameableClassTrait;

    /** @var string */
    private $lat;

    /** @var string */
    private $lon;

    /** @var string */
    private $temperature;

    /** @var UploadedFile */
    private $image;

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

    /**
     * @return string
     */
    public function getTemperature(): string
    {
        return $this->temperature;
    }

    /**
     * @return UploadedFile
     */
    public function getImage(): UploadedFile
    {
        return $this->image;
    }
}