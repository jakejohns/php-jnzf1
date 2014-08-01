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
 * @package   Validate
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\Validate;


/**
 * PasswordStrength
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
 * @see      \Zend_Validate_Abstract
 */
class PasswordStrength extends \Zend_Validate_Abstract
{
    const LENGTH = 'length';
    const UPPER  = 'upper';
    const LOWER  = 'lower';
    const DIGIT  = 'digit';
    const SYMBOL = 'symbol';

    /**
     * _messageTemplates
     *
     * @var array
     * @access protected
     */
    protected $_messageTemplates = array(
        self::LENGTH => "'%value%' must be at least 8 characters in length",
        self::UPPER  => "'%value%' must contain at least one uppercase letter",
        self::LOWER  => "'%value%' must contain at least one lowercase letter",
        self::DIGIT  => "'%value%' must contain at least one digit character",
        self::SYMBOL => "'%value%' must contain at least one non-alphanumeric character"
    );

    /**
     * _ignore
     *
     * @var array
     * @access protected
     */
    protected $_ignore = array();

    /**
     * __construct
     *
     * @param mixed $options
     * @access public
     * @return void
     */
    public function __construct($options = null)
    {
        if ($options) {
            $this->_ignore = (array) $options;
        }
    }

    /**
     * isValid
     *
     * @param mixed $value
     * @access public
     * @return void
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        $isValid = true;

        if (!in_array(self::LENGTH, $this->_ignore) && strlen($value) < 8) {
            $this->_error(self::LENGTH);
            $isValid = false;
        }

        if (!in_array(self::UPPER, $this->_ignore) && !preg_match('/[A-Z]/', $value)) {
            $this->_error(self::UPPER);
            $isValid = false;
        }

        if (!in_array(self::LOWER, $this->_ignore) && !preg_match('/[a-z]/', $value)) {
            $this->_error(self::LOWER);
            $isValid = false;
        }

        if (!in_array(self::DIGIT, $this->_ignore) && !preg_match('/\d/', $value)) {
            $this->_error(self::DIGIT);
            $isValid = false;
        }

        if(!in_array(self::SYMBOL, $this->_ignore) && !preg_match('/[^a-z0-9]/i', $value)){
            $this->_error(self::SYMBOL);
            $isValid = false;
        }

        return $isValid;
    }
}


