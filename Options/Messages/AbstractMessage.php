<?php
namespace HootSuite\Options\Messages;

use HootSuite\Options\OptionsAbstract;

abstract class AbstractMessage extends OptionsAbstract
{
    protected $messageid;

    public function setMessageId($messageid)
    {
        $this->messageid = $messageid;
        return $this;
    }
}