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
 * Uri
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
class Uri extends \Zend_Validate_Abstract
{
    const INVALID_URL = 'invalidUrl';
    
    protected $_messageTemplates = array(
        self::INVALID_URL   => "'%value%' is not a valid URL.",
    );

    /**
    * isValid
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @param mixed $value DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function isValid($value)
    {
        $valueString = (string) $value;
        $this->_setValue($valueString);
        if (!\Zend_Uri::check($value)) {
            $this->_error(self::INVALID_URL);
            return false;
        }
        return true;
    }
}


