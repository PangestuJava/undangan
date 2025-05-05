<?php

namespace App\Exceptions;

use Exception;
use App\Traits\HasHttpResponse;

class HandleResourceNotExistException extends Exception
{
    use HasHttpResponse;

    protected string $responseMessage;

    protected int $statusCode;

    public function __construct($responseMessage, $statusCode)
    {
        $this->responseMessage = $responseMessage;
        $this->statusCode = $statusCode;
        parent::__construct();
    }

    public function render()
    {
        return $this->notFound($this->responseMessage, $this->statusCode);
    }
}
