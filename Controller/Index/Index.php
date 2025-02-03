<?php
declare(strict_types=1);

namespace ApiLogger\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\Json;

class Index implements HttpGetActionInterface
{
    private RequestInterface $request;
    private JsonFactory $jsonFactory;

    public function __construct(
        RequestInterface $request,
        JsonFactory $jsonFactory
    ) {
        $this->request = $request;
        $this->jsonFactory = $jsonFactory;
    }

    public function execute(): Json
    {
        $status = match ($this->request->getParam('status')) {
            'success' => 'Operation completed successfully.',
            'error'   => 'There was an error processing your request.',
            default   => 'Status unknown.'
        };

        $result = $this->jsonFactory->create();
        $result->setData([
            'message' => $status,
            'timestamp' => (new \DateTimeImmutable())->format('c')
        ]);

        return $result;
    }
}
