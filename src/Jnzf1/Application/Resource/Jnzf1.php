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
 * @package   Application
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Application\Resource;
Use Jnzf1\Controller\Action\Helper\AclActions;

/**
 * Jnzf1
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
 * @see      \Zend_Application_Resource_ResourceAbstract
 */
class Jnzf1 extends \Zend_Application_Resource_ResourceAbstract
{



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
        $this->initFc();
        \Zend_Filter::addDefaultNamespaces('Jnzf1\Filter');

        \Zend_Paginator::setDefaultScrollingStyle('Sliding');
        \Zend_View_Helper_PaginationControl::setDefaultViewPartial(
            'pagination-control.phtml'
        );

        $options = $this->getOptions();

        if ($options['auth'] ) {
            $this->initAuth();
        }
    }

    /**
    * initFC
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function initFC ()
    {
        // to ensure helpersplugin for messages works right
        $this->getBootstrap()->bootstrap('frontController');
    }

    /**
    * initAuth
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function initAuth()
    {

        $userNav = new \Zend_Navigation();

        $userNav->addPage(
            array(
                'label' => 'Logout',
                'route' => 'logout'
            )
        );

        $userNav->addPage(
            array(
                'label' => 'Change Password',
                'controller' => 'authentication',
                'action' => 'password',
                'route' => 'default',
                'resource' => 'user',
                'privilege' => 'password'
            )
        );

        $userNav->addPage(
            array(
                'label' => 'Manage Users',
                'controller' => 'authentication',
                'action' => 'index',
                'route' => 'default',
                'resource' => 'user',
                'privilege' => 'manage'
            )
        );

        $this->getBootstrap()->bootstrap('view')
            ->getResource('view')
            ->assign('usernav', $userNav);


        $plugin = new AclActions();
        \Zend_Controller_Action_HelperBroker::addHelper($plugin);


        $router = $this->getBootstrap()->bootstrap('frontController')
            ->getResource('frontController')
            ->getRouter();

        $router->addRoute(
            'login',
            new \Zend_Controller_Router_Route_Static(
                'login',
                array('controller' => 'authentication', 'action' => 'login')
            )
        );

        $router->addRoute(
            'logout',
            new \Zend_Controller_Router_Route_Static(
                'logout',
                array('controller' => 'authentication', 'action' => 'logout')
            )
        );

    }

}


