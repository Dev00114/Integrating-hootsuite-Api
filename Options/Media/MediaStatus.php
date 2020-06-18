<?php
namespace HootSuite\Options\Media;

use HootSuite\Options\OptionsAbstract;

class MediaStatus extends OptionsAbstract
{
    protected $mediaid;

    public function setMediaId($mediaid)
    {
        $this->mediaid = $mediaid;
        return $this;
    }

    public function getEndPoint()
    {
        return "/v1/media/{$this->mediaid}";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}