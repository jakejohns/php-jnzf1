<?php
/**
 * Jnzf1 View Helper AutoLink
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
 * Jnzf1_View_Helper_Admin
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
class AutoLink extends \Zend_View_Helper_Abstract
{

    protected $linkPattern
        = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';

    /**
    * autoLink
    *
    * @param mixed $text     DESCRIPTION
    * @param mixed $nofollow DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
	public function autoLink($text, $nofollow = false)
	{
        return preg_replace_callback(
            $this->linkPattern,
            function ($matches) use ($nofollow) {
                $url = array_shift($matches);
                $text = parse_url($url, PHP_URL_HOST) 
                    . parse_url($url, PHP_URL_PATH);
                $text = preg_replace("/^www./", "", $text);
                $last = -(strlen(strrchr($text, "/"))) + 1;
                if ($last < 0) {
                    $text = substr($text, 0, $last) . "&hellip;";
                }

                if ($nofollow) {
                    $pattern = '<a rel="nofollow" href="%s">%s</a>';
                } else {
                    $pattern = '<a href="%s">%s</a>';
                }

                return sprintf($pattern, $url, $text);
            },
            $text
        );
	}
}


