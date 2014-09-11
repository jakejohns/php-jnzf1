<?php
/**
 * Jnzf1 View Helper Abbr
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
 * Jnzf1_View_Helper_Abbr
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
 * @see      Zend_View_Helper_Abstract
 */
class Abbr extends \Zend_View_Helper_Abstract
{

    protected $pattern = '<abbr title="%s">%s</abbr>';

    /**
    * abbr
    *
    * @param mixed $string DESCRIPTION
    * @param int   $length DESCRIPTION
    * @param mixed $hellip DESCRIPTION
    * @param mixed $abbr   DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function abbr($string, $length = 100, $hellip = true, $abbr = true)
    {
        $string = strip_tags($string);

        if (! strlen($string) > $length) {
            return $string;
        }

        $short = substr(
            $string,
            0,
            $length
        );

        if ($hellip) {
            $short = $short . '&hellip;';
        }

        if ($abbr) {
            $short = sprintf(
                $this->pattern,
                htmlentities($string),
                $short
            );
        }

        return $short;
    }


}


