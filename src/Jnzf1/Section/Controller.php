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
 * @package   Controller
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\Section;
use Jnzf1\Crud\Controller as BaseController;

/**
 * SectionsController
 *
 * @category CategoryName
 * @package  PackageName
 * @author   Jake Johns <jake@jakejohns.net>
 * @license  http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @version  Release: @package_version@
 * @link     http://jakejohns.net
 *
 * @see      Jnzf1_Model_Controller
 */
class Controller extends BaseController
{

    public $authActions = array(
        'index',
        'update',
        'view',
        'delete',
        'create'
    );

    protected $model;

    /**
    * getModel
    *
    * @return mixed
    *
    * @access public
    */
    public function getModel()
    {
        if (null == $this->model) {
            $this->model = new Model();
        }
        return $this->model;
    }

    /**
    * getForm
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function getForm()
    {
        return new Form();
    }


    /**
    * createAction
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function createAction()
    {
        throw new Exception('Cannot create a section!');
    }

    /**
    * deleteAction
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function deleteAction()
    {
        throw new Exception('Cannot delete a section!');
    }


    /**
    * gotoEntity
    *
    * @param mixed $entity DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function gotoEntity($entity)
    {
        $entity;
        return $this->_helper->redirector('index');
    }

    /**
    * indexAction
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function indexAction()
    {

        $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views';

        if (!file_exists($baseDir) || !is_dir($baseDir)) {
            throw new \Zend_Controller_Exception(
                'Missing base view directory ("' . $baseDir . '")'
            );
        }

        $this->view->setScriptPath($baseDir);
        $this->_helper->viewRenderer->setNoController();
        parent::indexAction();
    }

}









