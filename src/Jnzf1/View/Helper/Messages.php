<?php
/**
 * Jnzf1 Framework
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
 * @category  View
 * @package   Helper
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2013 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\View\Helper;

/**
 * Jnzf1_View_Helper_Messages
 *
 * View Helper for Flash MEssages and Alerts
 *
 * @category View
 * @package  Helper
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Zend_View_Helper_Abstract
 */
class Messages extends \Zend_View_Helper_Abstract
{
    /**
     * flashMessenger
     *
     * @var Zend_Controller_Action_Helper_FlashMessenger
     * @access protected
     */
    protected $flashMessenger;

    /**
     * messages
     * actual collected message data in its entirety includes flash and direct
     *
     * @var array
     * @access protected
     */
    protected $messages = array();

    /**
     * directMessages
     *
     * @var array
     * @access protected
     */
    protected $directMessages = array();


    /**
     * getFlashMessenger
     *
     * @access protected
     * @return void
     */
    protected function getFlashMessenger()
    {
        if (null === $this->flashMessenger) {
            $zfm = \Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger'
            );
            $this->flashMessenger = $zfm;
        }

        return $this->flashMessenger;
    }

    /**
     * addMessage
     *
     * @param string $message message to send
     * @param string $status  status of message
     *
     * @access public
     * @return Jnzf1_View_Helper_Messages
     */
    public function addMessage($message, $status = 'info')
    {
        $this->directMessages[] = array(
            'message'   => $message,
            'status'    => $status);
        return $this;
    }

    /**
     * getMessages
     *
     * @access protected
     * @return void
     */
    public function getMessages()
    {
        if (!count($this->messages)) {
            $flashData = $this->getFlashMessenger()->getMessages();
            $directData = $this->directMessages;
            $data = array_merge($flashData, $directData);

            foreach ($data as $message) {

                if (!is_array($message)) {
                    // if not an array
                    $text = $message;
                    $status = 'info';
                } elseif (!array_key_exists('status', $message)) {
                    // if no status message present
                    $text = $message['message'];
                    $status = 'info';
                } else {
                    // if properlly formed message
                    $text   = $message['message'];
                    $status = $message['status'];
                }

                $this->messages[] = array(
                    'message' => $text,
                    'status' => $status
                );
            }
        }
        return $this->messages;
    }

    /**
     * hasMessages
     *
     * @access public
     * @return void
     */
    public function hasMessages()
    {
        return ($this->getFlashMessenger()->hasMessages()
            || (bool) count($this->directMessages));
    }

    /**
     * getHtml
     *
     * @access public
     * @return void
     */
    public function getHtml()
    {
        if (!$this->hasMessages()) {
            return '';
        }

        $pattern = '<div class="alert alert-%s alert-dismissable">'
            . '<button type="button" class="close" '
            . 'data-dismiss="alert" aria-hidden="true">&times;</button>'
            . '%s</div>';

        $html = '<div class="alerts">';

        foreach ($this->getMessages() as $data) {
            $html .= sprintf($pattern, $data['status'], $data['message']);
        }

        $html .= "\n</div>";
        return $html;
    }

    /**
     * messages
     *
     * @access public
     * @return void
     */
    public function messages()
    {
        return $this;
    }

    /**
     * __toString
     *
     * @access public
     * @return void
     */
    public function __toString()
    {
        return $this->getHtml();
    }
}

