<?php

namespace Modules\Main\Components;


use Modules\Main\Models\User;
use Simff\Helpers\SmartProperties;
use Simff\Main\Simff;
use Simff\Model\Model;

class Auth
{
    use SmartProperties;

    /**
     * @var User
     */
    protected $_user = null;

    /**
     * Login expire
     * Default: 60 days
     * @var int
     */
    public $expire = 5184000;

    /**
     * @var string
     */
    public $authCookieName = 'USER';

    /**
     * @var string
     */
    public $authSessionName = 'USER_ID';

    public $class = User::class;

    public function login(Model $user, $rememberMe = true)
    {
        $this->updateSession($user);
        if ($rememberMe) {
            $this->updateCookie($user);
        }
        $this->setUser($user);
    }

    /**
     * @param bool $clearSession
     * @internal param bool $total Clear all session
     */
    public function logout($clearSession = true)
    {
        $this->removeSession($clearSession);
        $this->removeCookie();
        $this->_user = null;
    }

    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = $this->fetchUser();
        }
        return $this->_user;
    }

    public function setUser(Model $user)
    {
        $this->_user = $user;
        $this->updateCookie($user);
        $this->updateSession($user);
    }

    public function fetchUser()
    {
        $user = $this->getSessionUser();

        if (!$user) {
            if ($user = $this->getCookieUser()) {
                $this->updateSession($user);
            }

        }
        if (!$user) {
            $class = $this->class;
            $user = new $class();
            $user->is_guest = true;
        }
        return $user;
    }

    /**
     * Find user in database by id
     * @param $id
     */
    public function findUser($id)
    {
        /** @var Model $class */
        $class = $this->class;

        return $class::get($id);
    }

    public function getSessionUser()
    {
        $id = $this->getSession();

        if ($id) {
            return $this->findUser($id);
        }
        return null;
    }

    public function getCookieUser()
    {
        $cookie = $this->getCookie();
        if ($cookie) {
            $data = explode(':', $cookie);
            if (count($data) == 2) {
                $id = $data[0];
                $key = $data[1];

                $user = $this->findUser($id);
                if ($user && password_verify($user->email . $user->password, $key)) {
                    return $user;
                }
            }
        }
        return null;
    }

    public function updateSession(Model $user)
    {
        $this->setSession($user->pk);
    }

    public function updateCookie(Model $user)
    {
        $value = implode(':', [$user->pk, password_hash($user->email . $user->password, PASSWORD_DEFAULT)]);
        $this->setCookie($value);
    }

    public function setSession($session)
    {
        Simff::app()->request->session->add($this->authSessionName, $session);
    }

    public function getSession()
    {
        return Simff::app()->request->session->get($this->authSessionName);
    }

    public function removeSession($clearSession = true)
    {
        if ($clearSession) {
            Simff::app()->request->session->destroy();
        } else {
            Simff::app()->request->session->remove($this->authSessionName);
        }
    }

    public function setCookie($cookie)
    {
        Simff::app()->request->cookie->add($this->authCookieName, $cookie, time() + $this->expire, '/');
    }

    public function getCookie()
    {
        return Simff::app()->request->cookie->get($this->authCookieName);
    }

    public function removeCookie()
    {
        Simff::app()->request->cookie->remove($this->authCookieName);
    }
}