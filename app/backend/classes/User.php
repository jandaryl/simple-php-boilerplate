<?php

class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db = Database::getInstance();

        $this->_sessionName = Config::get('session/session_name');

        $this->_cookieName  = Config::get('remember/cookie_name');

        if (! $user)
        {
            if (Session::exists($this->_sessionName))
            {
                $user = Session::get($this->_sessionName);

                if ($this->find($user))
                {
                    $this->_isLoggedIn = true;
                }
            }

        }
        else
        {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null)
    {
        if (!$id && $this->isLoggedIn())
        {
            $id = $this->data()->uid;
        }

        if (!$this->_db->update('users', $id, $fields))
        {
            throw new Exception('Unable to update the user.');
        }
    }

    public function create($fields = array())
    {
        if (!$this->_db->insert('users', $fields))
        {
            throw new Exception("Unable to create the user.");
        }
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field  = (is_numeric($user)) ? 'uid' : 'username';

            $data = $this->_db->get('users', array($field, '=', $user));

            if ($data->count())
            {
                $this->_data = $data->first();
                return true;
            }
        }
    }

    public function login($username = null, $password = null, $remember = false)
    {
        if (! $username && ! $password && $this->exists())
        {
            Session::put($this->_sessionName, $this->data()->uid);
        }
        else
        {
            $user = $this->find($username);

            if ($user)
            {
                if (Password::check($password, $this->data()->password))
                {
                    Session::put($this->_sessionName, $this->data()->uid);

                    if ($remember)
                    {
                        $hash       = Hash::unique();
                        $hashCheck  = $this->_db->get('users_session', array('user_id', '=', $this->data()->uid));

                        if (!$hashCheck->count())
                        {
                            $this->_db->insert('users_session', array(
                                'user_id'   => $this->data()->uid,
                                'hash'      => $hash
                            ));
                        }
                        else
                        {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }

                    return true;
                }
            }
        }

        return false;
    }

    public function hasPermission($key)
    {
        $group = $this->_db->get('groups', array('gid', '=', $this->data()->groups));

        if  ($group->count())
        {
            $permissions = json_decode($group->first()->permissions, true);

            if ($permissions[$key] == true)
            {
                return true;
            }
        }

        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

    public function logout()
    {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->uid));

        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data()
    {
        return $this->_data;
    }

    public function isLoggedIn()
    {
        return $this->_isLoggedIn;
    }

    public function deleteMe()
    {
        if ($this->isLoggedIn())
        {
            $id = $this->data()->uid;
        }

        if (!$this->_db->delete('users', array('uid', '=', $id)))
        {
            throw new Exception('Unable to update the user.');
        }
    }
}
