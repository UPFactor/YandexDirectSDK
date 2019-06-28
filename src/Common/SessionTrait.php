<?php

namespace YandexDirectSDK\Common;

use YandexDirectSDK\Session;

trait SessionTrait
{
    /**
     * Session instance.
     *
     * @var Session
     */
    protected $session;

    /**
     * Set the session.
     *
     * @param Session $session|null
     * @return $this
     */
    public function setSession(Session $session = null){
        $this->session = $session;
        return $this;
    }

    /**
     * Retrieve the session.
     *
     * @return null|Session
     */
    public function getSession(){
        return $this->session;
    }
}