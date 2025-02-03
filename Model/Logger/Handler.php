<?php
declare(strict_types=1);

namespace ApiLogger\Model\Logger;

class Handler
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(array $request, array $response): void
    {
        try {
            $this->logger->logRequest($request);
            $this->logger->logResponse($response);
        } catch (\JsonException $e) {
            error_log('Logging failed: ' . $e->getMessage());
        }
    }
}
