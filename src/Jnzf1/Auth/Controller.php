<?php
/**
 * Jnzf1
 *
 * PHP version 5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Jnzfi
 * @package   Auth
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Auth;

/**
 * Controller
 *
 * Description Here!
 *
 * @category Jnzf1
 * @package  Auth
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @abstract
 */
abstract class Controller extends \Zend_Controller_Action
{

    public $resource = 'user';

    /**
     * authActions
     *
     * @var array
     * @access public
     */
    public $authActions = array(
        'index',
        'create',
        'update',
        'password'
    );

    /**
     * userModel
     *
     * @var Mac_Model_User
     * @access protected
     */
    protected $userModel;

    /**
     * auth
     *
     * @var Zend_Auth
     * @access protected
     */
    protected $auth;

    /**
    * getUserModel
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function getUserModel()
    {
        return new UserModel();
    }

    /**
    * getLoginForm
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function getLoginForm()
    {
        return new LoginForm();
    }

    /**
    * getUserForm
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function getUserForm()
    {
        return new UserForm();
    }

    /**
    * getPaswordForm
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function getPasswordForm()
    {
        return new PasswordForm();
    }

    /**
    * cfgview
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function cfgview()
    {
        $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views';

        if (!file_exists($baseDir) || !is_dir($baseDir)) {
            throw new \Zend_Controller_Exception(
                'Missing base view directory ("' . $baseDir . '")'
            );
        }

        $this->view->setScriptPath($baseDir);
        $this->_helper->viewRenderer->setNoController();
    }

    /**
    * init
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function init()
    {
        $this->auth = \Zend_Auth::getInstance();
        $this->cfgview();
    }

    /**
    * gotoDashboard
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function gotoDashboard()
    {
        return $this->_helper->redirector->gotoSimple('index', 'index');
    }

    /**
    * preDispatch
    *
    * check auth and sanity
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function preDispatch()
    {
        $action = $this->getRequest()->getActionName();
        $isAuthed = $this->auth->hasIdentity();

        $requireNoAuth = array('login', 'reset');

        // Don't login or rest if already logged in!
        if (in_array($action, $requireNoAuth)) {
            if ($isAuthed) {
                $this->_helper->flashMessenger(
                    'You are already authenticated!',
                    'info'
                );
                return $this->gotoDashboard();
            }
        } else {
            // if not logged in!
            if (! $isAuthed) {
                $this->_helper->flashMessenger(
                    'You are not authenticated!',
                    'info'
                );
                return $this->_helper->redirector->gotoRoute(array(), 'login');
            }
        }
    }

    /**
    * indexAction
    *
    * Display a paginated list of users to admins
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function indexAction()
    {
        $this->view->users = $this->getUserModel()->index();
        $this->view->page = $this->_getParam('page');
    }

    /**
    * loginAction
    *
    * authenticate a user
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function loginAction()
    {
        $form = $this->getLoginForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $result = $this->getUserModel()->authenticate($form->getValues());
                if ($result->isValid()) {
                    $this->_helper->flashMessenger(
                        'You are now logged in.',
                        'success'
                    );
                    return $this->gotoDashboard();
                } else {
                    $this->view->messages()->addMessage(
                        'Could not Authenticate',
                        'danger'
                    );
                }
            }
        }

        $this->view->form = $form;

    }

    /**
    * logoutAction
    *
    * clear authenticated user identity
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function logoutAction()
    {
        $this->auth->clearIdentity();
        $this->_helper->flashMessenger(
            'You have logged out',
            'success'
        );
        return $this->_helper->redirector->gotoSimple('index', 'index');
    }

    /**
    * updateAction
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function updateAction()
    {
        $request = $this->getRequest();
        $uid = $request->getParam('id');

        if (! $uid) {
            throw new Exception('No UID!');
        }

        $user = $this->getUserModel()->find($uid);

        if (! $user) {
            throw new Exception('Invalid user ID!');
        }

        $form = $this->getUserForm();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $result = $this->getUserModel()->update($uid, $form->getValues());
                if ($result) {
                    $this->_helper->flashMessenger(
                        'User updated',
                        'success'
                    );
                    return $this->gotoDashboard();
                }
            }
        } else {
            $form->bind($user);
        }

        $this->view->form = $form;
        $this->view->user = $user;
    }

    /**
    * createAction
    *
    * Create a user account
    *
    * @return mixed
    *
    * @access public
    */
    public function createAction()
    {
        $request = $this->getRequest();
        $form = $this->getUserForm();
        $model = $this->getUserModel();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($model->create($form->getValues())) {
                    $this->_helper->flashMessenger(
                        'Successfully created user account',
                        'success'
                    );
                    $this->gotoDashboard();
                }
            }
        }
        $this->view->form = $form;
    }

    /**
    * passwordAction
    *
    * change a password
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function passwordAction()
    {
        $request = $this->getRequest();
        $form = $this->getPasswordForm();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($this->getUserModel()->verify($form->getValue('current'))) {
                    $result = $this->getUserModel()->changePassword(
                        $form->getValue('password')
                    );
                    if ($result) {
                        $this->_helper->flashMessenger(
                            'Password Changed',
                            'success'
                        );
                        $this->_helper->flashMessenger(
                            'You must log in again',
                            'info'
                        );
                        \Zend_Auth::getInstance()->clearIdentity();
                        return $this->_helper->redirector->gotoRoute(
                            array(),
                            'login'
                        );
                    }
                } else {
                    $this->view->messages()->addMessage(
                        'Current Password Incorrent!',
                        'danger'
                    );
                }
            }
        }

        $this->view->form = $form;
    }

    /**
    * resetAction
    *
    * reset a password
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function resetAction()
    {
        // action body
    }
}

