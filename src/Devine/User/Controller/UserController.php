<?php

// UserController.php - General controller
// By Anton Van Eechaute

namespace Devine\User\Controller;

use Devine\User\Repository\UsersRepository;
use Devine\Framework\BaseController;
use Devine\User\Model\User;
use Devine\Framework\Validation;

class UserController extends BaseController
{
    public function registerAction()
    {
        $request = $this->getRequest();
        $data = $request->getPOST('register');

        // redirect to profile if logged in
        if ($request->get('user')) {
            $this->redirect('/user/profile');
        }

        // pass data to the template so they don't have to type it again (if they provided it)
        $this->add('reg_username', $data['username']);
        $this->add('reg_email', $data['email']);
        $this->add('reg_firstname', $data['firstname']);
        $this->add('reg_lastname', $data['lastname']);

        // initiate attempt to register an user if the form is submitted
        if ($request->isPOST()) {
            $rep = new UsersRepository();

            if (!$this->validateUser($rep, $data)) {
                // save user to the database
                $user = new User(null, $data['username'], $data['email'], $data['firstname'], $data['lastname'], null, $data['password'], $this->generateSalt());
                $user = $rep->saveUser($user);

                // remove password & salt from object for extra security
                $user->setPassword(null);
                $user->setSalt(null);

                // log in the user
                $request->set('user', $user);

                // redirect to home
                $this->redirect('/');
            }
        }

        $this->setTemplate('register_form');
    }

    public function loginAction()
    {
        $request = $this->getRequest();

        // redirect to profile if logged in
        if ($request->get('user')) {
            $this->redirect('/user/profile');
        }

        // process login
        if ($request->isPOST()) {
            $rep = new UsersRepository();
            $user = $rep->checkLogin($request->getPOST('username'), $request->getPOST('password'));

            // proceed if user is found otherwise show error
            if (false !== $user) {
                $request->set('user', $user);

                // process remember me
                if ($request->getPOST('remember_me')) {
                    $salt = $this->generateSalt(64);
                    $rep->addRememberMe($salt, $user->getId());
                    setcookie('remember_me', $salt, time()+4320000);
                }
                $request->set('loggedInEvent', true);
                $this->redirect('/');
            } else {
                $this->add('error_login', 'Gebruikersnaam of wachtwoord is onjuist.');
            }
        }

        $this->setTemplate('login_form');
    }

    public function logoutAction()
    {
        $request = $this->getRequest();

        if ($request->get('user')) {
            $request->set('user', null);
            setcookie('remember_me', '', time()-4320000);
            $request->set('loggedOutEvent', true);
            $this->redirect('/');
        } else {
            $this->forward404();
        }
    }

    public function profileAction()
    {
        $request = $this->getRequest();
        $user = $request->get('user');
        $data = $request->getPOST('profile');

        if ($user) {

            $this->add('profile_username', $user->getUsername());
            $this->add('profile_email', $user->getEmail());
            $this->add('profile_firstname', $user->getFirstName());
            $this->add('profile_lastname', $user->getLastName());

            if ($request->isPOST()) {
                $rep = new UsersRepository();

                $this->add('profile_username', $data['username']);
                $this->add('profile_email', $data['email']);
                $this->add('profile_firstname', $data['firstname']);
                $this->add('profile_lastname', $data['lastname']);

                if (!$this->validateUser($rep, $data, true)) {

                    $user->setUsername($data['username']);
                    $user->setFirstName($data['firstname']);
                    $user->setLastName($data['lastname']);
                    $user->setEmail($data['email']);

                    if ('' != $data['password']) {
                        $user->setPassword($data['password']);
                        $user->setSalt($this->generateSalt());
                    }

                    // save user to the database
                    $user = $rep->saveUser($user);

                    // remove password & salt from object for extra security
                    $user->setPassword(null);
                    $user->setSalt(null);

                    // log in the user
                    $request->set('user', $user);

                    // redirect to home
                    $this->redirect('/user/profile');
                }
            }

            $this->setTemplate('profile_form');

        } else {
            $this->forward404();
        }
    }

    private function validateUser($rep, $data, $check_old_pw = false)
    {
        $error = false;

        // validate user
        if ((!Validation::isMin($data['username'], 3)) || (!Validation::isMax($data['username'], 15)) || (!Validation::isAlpha($data['username']))) {
            $error = true;
            $this->add('error_username', 'Gebruikersnaam moet minstens 3, maximum 15 tekens lang en alfanumeriek zijn.');
        } elseif((null === $this->getRequest()->get('user') || $data['username'] !== $this->getRequest()->get('user')->getUsername()) && !$rep->isUsernameAvailable($data['username'])) {
            $error = true;
            $this->add('error_username', 'Gebruikersnaam is al in gebruik.');
        }
        if (!Validation::isEmail($data['email'])) {
            $error = true;
            $this->add('error_email', 'Email moet geldig zijn.');
        }
        if (($check_old_pw && ('' != $data['password'] && !Validation::isMin($data['password'], 6))) || (!$check_old_pw && !Validation::isMin($data['password'], 6))) {
            $error = true;
            $this->add('error_password', 'Paswoord moet minstens 6 tekens zijn.');
        }
        if ('' != $data['password'] && $data['password'] !== $data['password2']) {
            $error = true;
            $this->add('error_password2', 'Paswoorden zijn verschillend van elkaar.');
        }
        if ($check_old_pw && !$rep->checkPassword($this->getRequest()->get('user')->getUsername(), $data['old_password'])) {
            $error = true;
            $this->add('error_old_password', 'Oud paswoord is incorrect.');
        }

        return $error;
    }

    /**
     * Generates a salt of the given length
     * @param integer $len
     * @return string ¬†
     */
    private function generateSalt($len = 15)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+';
        $return = '';

        if ($len > 0) {
            $totalChars = strlen($chars) - 1;

            for ($i = 0; $i < $len; ++$i) {
                $return .= $chars[rand(0, $totalChars)];
            }
        }

        return $return;
    }
}
