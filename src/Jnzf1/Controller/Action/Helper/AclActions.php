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
 * @category  Jnzf1
 * @package   Controller
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Controller\Action\Helper;

/**
 * Jnzf1_Controller_Action_Helper_AuthActions
 *
 * Description Here!
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Zend_Controller_Action_Helper_Abstract
 */
class AclActions
    extends \Zend_Controller_Action_Helper_Abstract
{

    /**
     * _route
     *
     * @var string
     * @access protected
     */
    protected $route = 'login';

    /**
     * acl
     *
     * @var mixed
     * @access public
     */
    public $acl;

    /**
     * identity
     *
     * @var mixed
     * @access public
     */
    public $identity;

    /**
     * redirector
     *
     * @var mixed
     * @access public
     */
    public $redirector;

    /**
    * __construct
    *
    * @param mixed $loginRoute DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function __construct($loginRoute = null)
    {
        if ($loginRoute) {
            $this->route = $loginRoute;
        }

        $this->redirector = \Zend_Controller_Action_HelperBroker::getStaticHelper(
            'redirector'
        );

        $this->messages = \Zend_Controller_Action_HelperBroker::getStaticHelper(
            'flashMessenger'
        );
    }

    /**
    * getAcl
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getAcl()
    {
        if (null === $this->acl) {
            $this->acl = \Zend_Controller_Front::getInstance()
                ->getParam('bootstrap')
                ->getResource('acl');
        }
        return $this->acl;
    }

    /**
     * preDispatch
     *
     * @access public
     * @return void
     */
    public function preDispatch()
    {
        $authActions = $this->getAuthActions();
        $action = $this->getRequest()->getActionName();
        $hasIdentity = \Zend_Auth::getInstance()->hasIdentity();

        if ($authActions && in_array($action, $authActions)) {
            if (! $hasIdentity) {
                return $this->redirector->gotoRoute(array(), $this->route);
            }
            return $this->checkAcl($action);
        }
    }

    /**
    * checkAcl
    *
    * @param mixed $action DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function checkAcl($action)
    {
        $acl = $this->getAcl();
        $identity = $this->getIdentity();
        $resource = $this->getResource($action);

        if (! $acl->isAllowed($identity, $resource, $action)) {
            $this->messages->addMessage(
                'You are not allowed to do this!',
                'danger'
            );
            return $this->redirector->gotoSimple('index', 'index');
        }
    }

    /**
    * getResource
    *
    * @param mixed $action DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function getResource($action)
    {
        $controller = $this->getActionController();

        if ($controller->resource) {
            return $controller->resource;
        }

        $actions = $this->getAuthActions();
        $key = array_search($action, $actions);
        if (is_numeric($key)) {
            return $action;
        }
        return $key;
    }

    /**
    * getIdentity
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getIdentity()
    {
        $identity = \Zend_Auth::getInstance()
            ->getIdentity();

        if ($identity instanceof \Zend_Acl_Role_Interface) {
            return $identity;
        }

        foreach (array('role', 'roleId') as $prop) {
            if (property_exists($identity, $prop)) {
                return $identity->$prop;
            }
        }

        return 'guest';
    }

    /**
     * getAuthActions
     *
     * @access public
     * @return void
     */
    public function getAuthActions()
    {
        $controller = $this->getActionController();
        if (isset($controller->authActions)) {
            return (array) $controller->authActions;
        } else {
            return false;
        }
    }

}


