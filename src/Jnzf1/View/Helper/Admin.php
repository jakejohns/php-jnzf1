<?php
/**
 * Jnzf1 View Helper Admin
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
class Admin extends \Zend_View_Helper_Abstract
{

    /**
     * pattern
     *
     * @var string
     * @access protected
     */

    /**
    * admin
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @param array $actionData DESCRIPTION
    * @param mixed $urlData    DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function admin(array $actionData, $urlData)
    {
        $pattern = '<a href="%s">'
            . '<span class="glyphicon glyphicon-%s">&nbsp;</span>'
            . '%s</a>';

        $urlHelper = $this->view->getHelper('url');
        $listHelper = $this->view->getHelper('htmlList');
        $auth = $this->view->getHelper('auth');

        $items = array();

        foreach ($actionData as $action => $data) {

            $url = $urlHelper->url(
                array_merge(
                    array('action' => $action),
                    $urlData
                ), 'default', true
            );

            if ($auth->isAllowed($data['resource'], $data['privilege'])) {
                $items[] = sprintf(
                    $pattern,
                    $url,
                    $data['icon'],
                    $data['text']
                );
            }
        }

        if (! $items) {
            return;
        }

        return '<div class="admin-menu">'
            . $listHelper->htmlList(
                $items,
                false,
                array('class' => 'nav nav-pills'),
                false
            )
            . '</div>';
    }
}


