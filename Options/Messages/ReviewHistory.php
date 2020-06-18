<?php
namespace HootSuite\Options\Messages;

class ReviewHistory extends AbstractMessage
{
    public function getEndPoint()
    {
        return "/v1/messages/{$this->messageid}/history";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}