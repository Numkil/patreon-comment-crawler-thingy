<?php

namespace Crawler\Exceptions;

/**
 * Class CrawlerException
 * @package Crawler\Exceptions
 */
class CrawlerException extends \ErrorException
{

    private $context;

    /**
     * CrawlerException constructor.
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $filename
     * @param int $lineno
     * @param null $previous
     * @param array $context
     */
    public function __construct($message = "", $code = 0, $severity = 1, $filename = __FILE__, $lineno = __LINE__, $previous = null, $context = array()) {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param mixed $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }
}