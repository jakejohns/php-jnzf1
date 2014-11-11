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
* @category  View
* @package   Helper
* @author    Jake Johns <jake@jakejohns.net>
* @copyright 2014 Jake Johns
* @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
* @link      http://jakejohns.net
 */



namespace Jnzf1\View\Helper;

/**
 * DatePattern
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Zend_View_Helper_HtmlElement
 */
class DatePattern extends Zend_View_Helper_HtmlElement
{

    /**
     * defaultFormat
     *
     * @var string
     * @access protected
     */
    protected $defaultFormat = 'yyyy-MM-dd';

    /**
    * datePattern
    *
    * @param mixed $date    DESCRIPTION
    * @param mixed $format  DESCRIPTION
    * @param array $attribs DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function datePattern($date, $format = null, $attribs = array())
    {
        if (null === $date) {
            return 'null';
        }

        if (! $date instanceof Zend_Date) {
            throw new Exception('invalid date');
        }

        if (null === $format) {
            $format = $this->defaultFormat;
        }

        $attribs['title'] = $date->toString(Zend_Date::ATOM);

        return '<abbr '
            . $this->_htmlAttribs($attribs)
            . '>'
            . $date->toString($format)
            . '</abbr>';
    }
}





