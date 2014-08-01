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
 * @package   Wysiwyg
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */


namespace Jnzf1\Wysiwyg;


/**
 * ElfinderController
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
 * @see      Zend_Controller_Action
 */
class Controller extends \Zend_Controller_Action
{

    /**
     * resource
     *
     * @var string
     * @access public
     */
    public $resource = 'files';

    /**
     * authActions
     *
     * @var array
     * @access public
     */
    public $authActions = array('index');

    /**
    * init
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function init()
    {
        $elfinderdir = APPLICATION_PATH . '/../public/'
            . 'js/vendor/wysiwyg/elfinder/php/';

        include_once $elfinderdir . 'elFinderConnector.class.php';
        include_once $elfinderdir . 'elFinder.class.php';
        include_once $elfinderdir . 'elFinderVolumeDriver.class.php';
        include_once $elfinderdir . 'elFinderVolumeLocalFileSystem.class.php';
    }

    /**
    * indexAction
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function indexAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);

        $path = APPLICATION_PATH . '/../public/uploads/';

        $opts = array(
        // 'debug' => true,
            'roots' => array(
                array(
                    'driver'        => 'LocalFileSystem',
                    'path'          => $path,
                    'URL'           => '/uploads/',
                    'accessControl' => array($this, 'access')
                )
            )
        );

        // run elFinder
        $connector = new \elFinderConnector(new \elFinder($opts));
        $connector->run();
    }


    /**
    * access
    *
    * Simple function to demonstrate how to control file access using
    * "accessControl" callback.
    * This method will disable accessing files/folders starting from  '.' (dot)
    *
    * @param string $attr   attribute name (read|write|locked|hidden)
    * @param string $path   file path rel to vol root dir start with dir separator
    * @param mixed  $data   DESCRIPTION
    * @param mixed  $volume DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function access($attr, $path, $data, $volume) 
    {
        $data;
        $volume;
        return strpos(basename($path), '.') === 0
            ? !($attr == 'read' || $attr == 'write')
            :  null;
    }

}

