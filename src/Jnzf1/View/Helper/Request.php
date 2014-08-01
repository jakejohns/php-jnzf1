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
 * Request
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
 * @see      \Zend_View_Helper_Abstract
 */
class Request extends \Zend_View_Helper_Abstract
{

    /**
     * request
     *
     * @var Zend_Controller_Request_Abstract
     * @access protected
     */
    protected $request;

    /**
    * setRequest
    *
    * @param \Zend_Controller_Request_Abstract $request DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function setRequest(\Zend_Controller_Request_Abstract $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * gets request
     *
     * @access public
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest()
    {
        if (null === $this->request) {
            $request = \Zend_Controller_Front::getInstance()->getRequest();
            $this->setRequest($request);
        }
        return $this->request;
    }

    /**
     * isHomepage
     *
     * @access public
     * @return void
     */
    public function isHomepage()
    {
        $request    = $this->getRequest();
        $dispatcher = \Zend_Controller_Front::getInstance()->getDispatcher();

        return (($dispatcher->getDefaultModule() === $request->getModuleName())
            && (
                $dispatcher->getDefaultControllerName()
                === $request->getControllerName()
            )
            && ($dispatcher->getDefaultAction() === $request->getActionName()));
    }


    /**
     * request
     *
     * @access public
     * @return Jnzf1_View_Helper_Request
     */
    public function request()
    {
        return $this;
    }
}

