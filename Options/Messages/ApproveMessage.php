<?php
namespace HootSuite\Options\Messages;

class ApproveMessage extends AbstractMessage
{
    public function getEndPoint()
    {
        return "/v1/messages/{$this->messageid}/approve";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_POST;
    }
}