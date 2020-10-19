<?php
declare(strict_types=1);

namespace Weather\Weather\Command;

/**
 * Class CreateReportHandler
 * @author Komala Surya <komala.surya.w@gmail.com>
 */
final class CreateReportHandler
{
    public function __construct()
    {
    }

    public function handle(CreateReport $message)
    {
        return $message->payload()->all();
    }
}