<?php
declare(strict_types=1);

namespace Shared\Exception;

use ReflectionObject;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
class Exception extends HttpException
{
    /**
     * @var AbstractErrors
     */
    private $error;
    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor.
     *
     * @param AbstractErrors $error
     * @param array          $params
     * @param Throwable|null $previous
     */
    public function __construct(AbstractErrors $error, array $params = [], Throwable $previous = null)
    {
        $reflection = new ReflectionObject($error);

        $this->error = $error;
        $this->params = $params;
        $this->type = $reflection->getShortName();

        parent::__construct(
            $error->getHttpStatusCode(),
            __($error->getErrorMessage(), $params),
            $previous
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->error->getHttpStatusCode();
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->error->getValue();
    }
}
