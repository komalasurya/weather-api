<?php
declare(strict_types=1);

namespace Shared\Exception;

use RuntimeException;
use Shared\Value\AbstractEnum;

/**
 * @author  Iqbal Maulana <iq.bluejack@gmail.com>
 */
abstract class AbstractErrors extends AbstractEnum
{
    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        $messages = $this->availableErrorMessages();

        if (!isset($messages[$this->getValue()])) {
            throw new RuntimeException(
                __('Error code :code not found.', ['code' => $this->getValue()])
            );
        }

        return $messages[$this->getValue()];
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return (int) substr((string) $this->getValue(), 0, 3);
    }

    /**
     * @return array|string[]
     */
    abstract protected function availableErrorMessages(): array;
}
