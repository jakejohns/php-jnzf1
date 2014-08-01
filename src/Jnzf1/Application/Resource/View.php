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
 * @package   Application
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Application\Resource;

/**
 * Jnzf1
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
 * @see      \Zend_Application_Resource_ResourceAbstract
 */
class View extends \Zend_Application_Resource_View
{


    /**
    * getView
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getView()
    {
        if (null === $this->_view) {
            $options = $this->getOptions();
            $appNamespace = $this->getBootstrap()->getAppNamespace();

            $this->_view = new \Zend_View($options);
            $this->_view
                ->addHelperPath(
                    'ZendX/JQuery/View/Helper/',
                    'ZendX_JQuery_View_Helper'
                )->addHelperPath(
                    'Jnzf1/View/Helper',
                    'Jnzf1\View\Helper'
                )->addHelperPath(
                    APPLICATION_PATH . '/views/helpers/',
                    $appNamespace . 'View_Helper'
                );

            $this->_view->addFilterPath('Jnzf1/Filter', 'Jnzf1\Filter');

            if (isset($options['doctype'])) {
                $this->_view->doctype()->setDoctype(strtoupper($options['doctype']));
            } else {
                $this->_view->doctype()->setDoctype('HTML5');
            }
        }
        return $this->_view;
    }

}


