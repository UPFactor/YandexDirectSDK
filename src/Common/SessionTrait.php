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
     * @param Session $session
     * @return void
     */
    public function setSession(Session $session){
        $this->session = $session;
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