<?php
namespace HootSuite\Options\SocialProfile;

use HootSuite\Options\OptionsAbstract;
use HootSuite\Exception\InvalidMimeTypeException;

class SocialProfiles extends OptionsAbstract
{

    public function getEndPoint()
    {
        return "/v1/socialProfiles";
    }

    /**
     * @return string
     */
    public function getRequestType(){
        return self::REQUEST_TYPE_GET;
    }
}