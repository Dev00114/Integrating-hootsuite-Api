<?php
namespace HootSuite\Options\Messages;

class RejectMessage extends AbstractMessage
{
    public function getEndPoint()
    {
        return "/v1/messages/{$this->messageId}/reject";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_POST;
    }
}