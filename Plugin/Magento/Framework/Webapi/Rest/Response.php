<?php
declare(strict_types=1);

namespace PSSoftware\ApiLogger\Plugin\Magento\Framework\Webapi\Rest;

use Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use PSSoftware\ApiLogger\Model\Logger\Logger;

class Response
{
    const API_LOGGER_ENABLED = 'pssoftware_api_logger/general/enabled';
    const API_LOGGER_ALLOWED_LOG_HEADERS = 'pssoftware_api_logger/general/allowed_log_headers';

    /**
     * @var Logger
     */
    protected $_logger;

    /**
     * @var TimezoneInterface
     */
    protected $_date;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var SerializerInterface
     */
    private $_serializer;

    /**
     * RestApiLog constructor.
     *
     * @param Logger                $logger
     * @param TimezoneInterface     $date
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface  $scopeConfig
     * @param SerializerInterface   $serializer
     */
    public function __construct(
        Logger $logger,
        TimezoneInterface $date,
        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfig,
        SerializerInterface $serializer
    ) {
        $this->_logger = $logger;
        $this->_date = $date;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_serializer = $serializer;
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject,
        $result
    ) {
        try {
            if (!$this->_scopeConfig->getValue(self::API_LOGGER_ENABLED, ScopeInterface::SCOPE_STORE)) {
                return $result;
            }

            $requestedLogData = [
                'responseStatus' => $subject->getReasonPhrase(),
                'responseStatusCode' => $subject->getStatusCode(),
                'responseBody' => $subject->getBody()
            ];

            if ($this->_scopeConfig->getValue(self::API_LOGGER_ALLOWED_LOG_HEADERS, ScopeInterface::SCOPE_STORE)) {
                $requestedLogData['header'] = $this->getHeadersData($subject->getHeaders());
            }

            $this->_logger->debug('Response = ' . $this->_serializer->serialize($requestedLogData));
        } catch (Exception $exception) {
            $this->_logger->critical($exception->getMessage(), ['exception' => $exception]);
        }

        return $result;
    }


    /**
     * Method for getting all available data in header and convert them to array
     *
     * @param  $headers
     * @return array
     */
    private function getHeadersData($headers): array
    {
        $headerLogData = [];
        foreach ($headers as $header) {
            $headerLogData[$header->getFieldName()] = $header->getFieldValue();
        }
        return $headerLogData;
    }

}

