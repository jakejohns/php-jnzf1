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
 * @package   Form
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\Auth;
use Jnzf1\Form as Form;

/**
 * Jnzf1_Form_Login
 *
 * login form
 *
 * @category Jnzf1
 * @package  Form
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Jnzf1_Form_Base
 */
class LoginForm extends Form
{

    /**
    * init
    *
    * @return mixed
    *
    * @access public
    */
    public function init()
    {
        $this->setMethod('post');

        $this->addElement(
            'text', 'username', array(
                'label' => 'Username:',
                'required' => true,
                'filters'    => array('StringTrim'),
            )
        );

        $this->addElement(
            'password', 'password', array(
                'label' => 'Password:',
                'required' => true,
            )
        );

        $this->addElement(
            'submit', 'submit', array(
                'ignore'   => true,
                'label'    => 'Login',
            )
        );
    }
}


