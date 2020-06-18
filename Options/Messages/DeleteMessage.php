<?php
namespace HootSuite\Options\Messages;

class DeleteMessage extends AbstractMessage
{
    public function getEndPoint()
    {
        return "/v1/messages/{$this->messageid}";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_DELETE;
    }
}