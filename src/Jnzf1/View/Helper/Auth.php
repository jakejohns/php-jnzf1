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
 * Jnzf1_View_Helper_Auth
 *
 *  auth helper
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
class Auth extends \Zend_View_Helper_Abstract
{

    /**
     * auth
     *
     * @var mixed
     * @access public
     */
    public $auth;

    /**
     * acl
     *
     * @var Zend_Acl
     * @access public
     */
    public $acl;

    /**
    * __construct
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function __construct()
    {
        $this->auth = \Zend_Auth::getInstance();
        $this->acl = \Zend_Controller_Front::getInstance()
            ->getParam('bootstrap')
            ->getResource('acl');
    }

    /**
    * auth
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function auth()
    {
        return $this;
    }

    /**
    * getRole
    *
    * gets role string of current user. guest if none
    *
    * @return string
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getRole()
    {
        if ($this->auth->hasIdentity()) {
            return $this->auth->getIdentity()->role;
        } else {
            return 'guest';
        }
    }

    /**
    * isAllowed
    *
    * @param mixed $resource DESCRIPTION
    * @param mixed $privlege DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function isAllowed($resource, $privlege = null)
    {
        return $this->acl->isAllowed(
            $this->getRole(),
            $resource,
            $privlege
        );
    }

}


