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

namespace Jnzf1\Controller\Plugin;

/**
 * StaticRoutes
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
 * @see      \Zend_Controller_Plugin_Abstract
 */
class StaticRoutes extends \Zend_Controller_Plugin_Abstract
{
    /**
    * routeStartup
    *
    * @param \Zend_Controller_Request_Abstract $request DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function routeStartup(\Zend_Controller_Request_Abstract $request)
    {
        $dispatcher = \Zend_Controller_Front::getInstance()->getDispatcher();

        $defaultController = $dispatcher->getDefaultControllerClass($request);
        $controllerClass = $dispatcher->loadClass($defaultController);
        $class = new \ReflectionClass($controllerClass);

        if ($class) {
            $methods = $class->getMethods();
            $this->addStaticRoutes($methods, $defaultController);
        }
    }

    /**
    * addStaticRoutes
    *
    * @param mixed $methods DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function addStaticRoutes($methods)
    {
        if (!is_array($methods) || empty($methods)) {
            return false;
        }
        $router = \Zend_Controller_Front::getInstance()->getRouter();

        foreach ($methods as $method) {
            if ($method->isPublic() 
                && $this->isAction($method) 
                && !$this->isDefaultAction($method)
            ) {
                $action = $this->dasherise($method->getName());
                $router->addRoute($action, $this->pageRoute($action));
            }
        }
        $router->addRoute(
            'home', 
            $this->pageRoute($this->nameForDefault('action'))
        );
    }

    /**
    * pageRoute
    *
    * @param mixed $action DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function pageRoute($action)
    {
        return new \Zend_Controller_Router_Route_Static(
            $action,
            array(
                'module' => $this->nameForDefault('module'),
                'controller' => $this->nameForDefault('controller'),
                'action' => $action
            )
        );
    }

    /**
    * isDefaultAction
    *
    * @param mixed $method DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function isDefaultAction($method)
    {
        return (
            $this->dasherise($method->getName()) == $this->nameForDefault('action')
        );
    }

    /**
    * isAction
    *
    * @param mixed $method DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function isAction($method)
    {
        return (preg_match('/Action/', $method->getName()));
    }

    /**
    * nameForDefault
    *
    * @param mixed $segment DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function nameForDefault($segment)
    {
        $front = \Zend_Controller_Front::getInstance();
        $segment = ucfirst(trim($segment));
        if ($segment == 'Controller') {
            $segment .= 'Name';
        }
        $method = 'getDefault' . $segment;
        return $front->{$method}();
    }

    /**
    * dasherise
    *
    * @param mixed $name DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function dasherise($name)
    {
        $name = str_replace('Action', '', $name);
        $inflector = new \Zend_Filter_Inflector(':name');
        $inflector->setRules(
            array(
                ':name'  => array('Word_CamelCaseToDash', 'StringToLower')
            )
        );
        return $inflector->filter(array('name' => $name));
    }

}


