<?php
/**
 * Jnzf1 Document Row Class
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
 * @package   Model
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Crud\DbTable;

/**
 * Jnzf1_Model_DbTable_Row_Base
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
 * @see      Zend_Db_Table_Row_Abstract
 */
abstract class Row extends \Zend_Db_Table_Row_Abstract
{

    /**
    * getBookmarkController
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    abstract protected function getBookmarkController();

    /**
    * getUrlHelper
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getUrlHelper()
    {
        return \Zend_Controller_Action_HelperBroker::getStaticHelper('url');
    }

    /**
    * getBookmark
    *
    * @param mixed $action DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function getBookmark($action = null)
    {
        if (null == $action) {
            $action = 'view';
        }

        return $this->getUrlHelper()->url(
            array(
                'controller' => $this->getBookmarkController(),
                'action' => $action,
                'id' => $this->uid
            ),
            'default',
            true
        );
    }


    /**
    * _insert
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function _insert()
    {
        if (isset($this->created)) {
            $this->created = date('Y-m-d H:i:s');
        }

        if (isset($this->updated)) {
            $this->updated = date('Y-m-d H:i:s');
        }

        $userid = \Zend_Auth::getInstance()->getIdentity()->uid;

        if (isset($this->updaterId)) {
            $this->updaterId = $userid;
        }

        if (isset($this->creatorId)) {
            $this->creatorId = $userid;
        }
    }

    /**
    * _update
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function _update()
    {
        if (isset($this->updated)) {
            $this->updated = date('Y-m-d H:i:s');
        }

        $userid = \Zend_Auth::getInstance()->getIdentity()->uid;

        if (isset($this->updaterId)) {
            $this->updaterId = $userid;
        }
    }


}

