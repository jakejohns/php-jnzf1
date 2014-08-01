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
 * @package   View
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\View\Helper;

/**
 * Jnzf1_View_Helper_ContainerClass
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
 * @see      Zend_View_Helper_Abstract
 */
class ContainerClass extends \Zend_View_Helper_Abstract
{
    protected $extra = array();
    protected $mvc   = array();
    protected $auth  = array();

    protected $classArray = array();

    /**
    * add
    *
    * @param mixed $class DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function add($class)
    {
        if (!in_array($class, $this->_extra)) {
            $this->extra[] = $class;
        }
        return $this;
    }

    /**
    * getMvcClasses
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getMvcClasses()
    {
        if (!count($this->mvc)) {
            $request = $this->view->request()->getRequest();
            $this->mvc = array(
                'mvc-module-'       . $request->getModuleName(),
                'mvc-controller-'   . $request->getControllerName(),
                'mvc-action-'       . $request->getACtionName(),
                $this->getHomepageClass()
            );
        }
        return $this->mvc;
    }

    /**
     * getHomepageClass
     *
     * @access public
     * @return void
     */
    public function getHomepageClass()
    {
        if ($this->view->request()->isHomepage()) {
            return 'mvc-homepage';
        } else {
            return 'mvc-not-homepage';
        }

    }

    /**
     * getAuthClasses
     *
     * @access public
     * @return void
     */
    public function getAuthClasses()
    {
        if (!count($this->auth)) {
            $auth = \Zend_Auth::getInstance();
            if ($auth->hasIdentity()) {
                $this->auth = array('auth-yes');
            } else {
                $this->auth = array('auth-no');
            }
        }
        return $this->auth;
    }


    /**
     * getExtraClasses
     *
     * @access public
     * @return void
     */
    public function getExtraClasses()
    {
        return $this->extra;
    }

    /**
     * containerClass
     *
    * @access public
     * @return void
     */
    public function containerClass()
    {
        return $this;
    }

    /**
    * getClassArray
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getClassArray()
    {
        if (!count($this->classArray)) {
            $this->classArray = array_merge(
                $this->getMvcClasses(),
                $this->getAuthClasses(),
                $this->getExtraClasses()
            );
        }
        return $this->classArray;
    }

    /**
    * hasClass
    *
    * @param mixed $string DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function hasClass($string)
    {
        return in_array($string, $this->getClassArray());
    }

    /**
     * getClassString
     *
     * @access public
     * @return void
     */
    public function getClassString()
    {
        $classes = $this->getClassArray();
        return implode(' ', $classes);
    }

    /**
     * __toString
     *
     * @access public
     * @return void
     */
    public function __toString()
    {
        return $this->getClassString();
    }

}


