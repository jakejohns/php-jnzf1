<?php
/**
 * Jnzf1 Base Controller
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


namespace Jnzf1\Crud;

use Jnzf1\Form\Confirm as ConfirmForm;


/**
 * Jnzf1_Model_Controller
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
 * @abstract
 */
abstract class Controller extends \Zend_Controller_Action
{

    public $resource;

    /**
     * authActions
     *
     * @var array
     * @access public
     */
    public $authActions = array(
        'create',
        'update',
        'delete'
    );

    /**
    * getForm
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    abstract public function getForm();

    /**
    * getModel
    *
    * Summaries for methods should use 3rd person declarative rather
    * than 2nd person imperative, beginning with a verb phrase.
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    abstract public function getModel();


    /**
    * cfgview
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function cfgview()
    {
        $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views';

        if (!file_exists($baseDir) || !is_dir($baseDir)) {
            throw new \Zend_Controller_Exception(
                'Missing base view directory ("' . $baseDir . '")'
            );
        }

        $this->view->setScriptPath($baseDir);
        $this->_helper->viewRenderer->setNoController();
    }


    /**
    * preDispatch
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function preDispatch()
    {
        $action = $this->getRequest()->getActionName();
        $base = array('create', 'update', 'delete');
        if (in_array($action, $base)) {
            $this->cfgview();
        }
    }

    /**
    * loadEntity
    *
    * @return mixed
    * @throws Zend_Controller_Action_Exception [description]
    *
    * @access public
    */
    public function loadEntity()
    {
        $request = $this->getRequest();
        $uid = $request->getParam('id');

        if (! $uid) {
            $this->_helper->flashMessenger->addMessage(
                sprintf('No %s id  specified!', $this->resource),
                'warning'
            );
            return $this->_helper->redirector->direct('index');
        }

        $entity = $this->getModel()->find($uid);

        if (!$entity) {
            throw new \Zend_Controller_Action_Exception(
                sprintf('%s not found', $this->resource),
                404
            );
        }

        return $entity;
    }


    /**
    * gotoEntity
    *
    * @param mixed $entity DESCRIPTION
    *
    * @return mixed
    *
    * @access protected
    */
    protected function gotoEntity($entity)
    {
        if (method_exists($entity, 'getBookmark')) {
            return $this->_helper->redirector->gotoUrl(
                $entity->getBookmark()
            );
        }

        return $this->_helper->redirector->gotoSimple(
            'view',
            $this->getRequest()->getControllerName(),
            null,
            array('id' => $entity->uid)
        );
    }

    /**
    * init
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function init()
    {
        $this->resource = $this->getModel()->getEntityName();
        $this->view->resource = $this->resource;
    }

    /**
     * indexAction
     *
     * paginated listing of learn
     *
     * @return void
     *
     * @access public
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $this->view->entities = $this->getModel()->index($request->getParams());
        $this->view->request = $request;
        $this->view->page = $request->getParam('page', 1);
    }

    /**
     * createAction
     *
     * create a entity record
     *
     * @return void
     *
     * @access public
     *
     *
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $form = $this->getForm()->create();
        $model = $this->getModel();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $entity = $model->factory($form->getValues());
                if ($entity = $model->save($entity)) {
                    $this->_helper->flashMessenger(
                        sprintf('Successfully created %s!', $this->resource), 
                        'success'
                    );
                    return $this->gotoEntity($entity);
                }
            }
        }
        $this->view->form = $form;
    }

    /**
     * viewAction
     *
     * view an individual entity
     *
     * @return void
     *
     * @access public
     */
    public function viewAction()
    {
        $this->view->entity = $this->loadEntity();
    }

    /**
     * updateAction
     *
     * update a entity
     *
     * @return void
     *
     * @access public
     */
    public function updateAction()
    {
        $request = $this->getRequest();
        $form = $this->getForm()->update();
        $form->submit->setLabel('Update');

        $entity = $this->loadEntity();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                $entity->setFromArray($form->getValues());
                if ($entity = $this->getModel()->save($entity)) {
                    $this->_helper->flashMessenger(
                        sprintf('Successfully updated %s!', $this->resource), 
                        'success'
                    );
                    return $this->gotoEntity($entity);
                }
            }
        } else {
            $form->bind($entity);
        }

        $this->view->entity = $entity;
        $this->view->form = $form;
    }

    /**
     * deleteAction
     *
     * delete a entity
     *
     * @return void
     *
     * @access public
     */
    public function deleteAction()
    {
        $request = $this->getRequest();
        $form = new ConfirmForm();

        $entity = $this->loadEntity();

        if ($request->isPost()) {
            if ($form->isValid($request->getPost())) {
                if ($form->isConfirmed()) {
                    if ($this->getModel()->delete($entity)) {
                        $this->_helper->flashMessenger(
                            sprintf('Successfully deleted %s!', $this->resource), 
                            'success'
                        );
                        return $this->_helper->redirector('index');
                    }
                } else {
                    $this->view->messages()->addMessage(
                        'Action not confirmed!',
                        'danger'
                    );
                }
            }
        }

        $this->view->form = $form;
        $this->view->entity = $entity;
    }

}









