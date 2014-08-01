<?php
/**
 * Jnzf1 Confirmation Form
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
 * @package   Form
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2013 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Form;

use Jnzf1\Form as Form;

/**
 * Jnzf1_Form_Confirm
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
 * @see      Jnzf1_Form_Base
 */
class Confirm extends Form
{

    /**
    * init
    *
    * adds confirmation options
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function init()
    {
        $this->setAttrib('id', 'confirmform');
        $txt = 'To confirm this action, change the selection to "Confirmed"';
        $this->addElement(
            'select', 'confirmed', array(
                'label' => 'Confirm Action',
                'required' => true,
                'description' => $txt,
                'multioptions' => array('NOT Confirmed', 'Confirmed')
            )
        );

        $this->addElement(
            'button', 'submit', array(
                'label'         => 'Submit',
                'ignore'        => true,
                'type'          => 'submit',
                'buttonType'    => 'error',
            )
        );
    }

    /**
    * isConfirmed
    *
    * returns true if form was set to confirmed status
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function isConfirmed()
    {
        return $this->getValue('confirmed');
    }

    /**
    * render
    *
    * adds JS for confirmation
    *
    * @param Zend_View_Interface $view view object
    *
    * @return string
    *
    * @access public
    */
    public function render(Zend_View_Interface $view = null)
    {
        $return =  parent::render($view);
        return $return;
    }

}
