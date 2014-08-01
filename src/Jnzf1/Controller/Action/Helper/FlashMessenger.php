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
 * FlashMessenger
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
 * @see      Zend_Controller_Action_Helper_FlashMessenger
 */
class FlashMessenger extends \Zend_Controller_Action_Helper_FlashMessenger
{

    const STATUS_SUCCESS = 'success';
    const STATUS_INFO = 'info';
    const STATUS_ERROR = 'error';

    /**
    * addMessage
    *
    * @param mixed $message DESCRIPTION
    * @param mixed $status  DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function addMessage($message, $status = self::STATUS_SUCCESS)
    {
        return parent::addMessage(
            array(
                'status'    => $status,
                'message'   => $message
            )
        );
    }

    /**
    * direct
    *
    * @param mixed $message DESCRIPTION
    * @param mixed $status  DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function direct($message, $status = self::STATUS_SUCCESS)
    {
        return $this->addMessage($message, $status);
    }

}

