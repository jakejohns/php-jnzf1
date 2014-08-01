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
 * @package   View
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\View\Helper;
use Jnzf1\Section\Model as SectionModel;

/**
 * Jnzf1_View_Helper_Section
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
class Section extends \Zend_View_Helper_Abstract
{

    /**
     * section
     *
     * @var mixed
     * @access public
     */
    public $sections;


    /**
    * __construct
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function __construct()
    {
        $this->sections = new SectionModel();
    }

    /**
    * section
    *
    * @param mixed $uid DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function section($uid)
    {
        $section = $this->sections->find($uid);


        $actions = $this->view->admin(
            array(
                'update' => array(
                    'text' => 'Update',
                    'icon' => 'edit',
                    'resource' => 'section',
                    'privilege' => 'update'
                ),
            ),
            array('controller' => 'section', 'id' => $section->uid)
        );

        return sprintf(
            '<div id="section-id-%s">%s %s</div>',
            $section->uid,
            $actions,
            $section->section
        );

    }


}


