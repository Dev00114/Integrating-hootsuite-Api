<?php
namespace HootSuite\Options\Media;

use HootSuite\Options\OptionsAbstract;

class CreateUrl extends OptionsAbstract
{
    const valid_mimeTypes = ["video/mp4", "image/gif", "image/jpeg", "image/jpg", "image/png"];

    protected $sizeBytes;
    protected $mimeType;

    public function setSizeBytes($size)
    {
        $this->sizeBytes = $size;
        return $this;
    }

    public function setMimeType($mimeType)
    {
        $is_contain = false;
        foreach (self::valid_mimeTypes as $value) {
            if($value === $mimeType)
                $is_contain = true;
        }
        if( ! $is_contain)
            throw new \Exception("Invalid mimeType exception. please check the mimeType again.", 1);

        $this->mimeType = $mimeType;
        return $this;            
    }

    public function getEndPoint()
    {
        return "/v1/media";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_POST;
    }
}