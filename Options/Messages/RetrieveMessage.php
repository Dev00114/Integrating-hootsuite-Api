<?php
namespace HootSuite\Options\Messages;

use HootSuite\Options\OptionsAbstract;

class RetrieveMessage extends OptionsAbstract
{
    public function getEndPoint()
    {
        return "/v1/messages/{$this->messageId}";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}