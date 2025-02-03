<?php
declare(strict_types=1);

namespace ApiLogger\Model\Logger;

use Psr\Log\LoggerInterface;

class Logger
{
    private readonly LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logRequest(array $data): void
    {
        $message = json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $this->logger->info('API Request', ['data' => $message]);
    }

    public function logResponse(array $data): void
    {
        $message = json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $this->logger->info('API Response', ['data' => $message]);
    }
}
