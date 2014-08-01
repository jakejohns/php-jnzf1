<?php
/**
 * Jnzf1 Base Model
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
 * @package   Model
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\Crud;

/**
 * Jnzf1_Model_Base
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
 * @abstract
 */
abstract class Model
{

    /**
     * tables
     *
     * @var array
     * @access protected
     */
    protected $tables = array();

    /**
     * definition
     *
     * @var mixed
     * @access protected
     */
    protected static $definition;

    /**
    * getEntityName
    *
    * @return mixed
    *
    * @access public
    */
    abstract public function getEntityName();


    /**
    * setTableDefinition
    *
    * @param \Zend_Db_Table_Definition $def DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    * @static
    */
    public static function setTableDefinition(\Zend_Db_Table_Definition $def)
    {
        self::$definition = $def;
    }

    /**
    * getDefinition
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getDefinition()
    {
        return self::$definition;
    }

    /**
    * getTable
    *
    * @param mixed $name DESCRIPTION
    *
    * @return mixed
    *
    * @access protected
    */
    protected function getTable($name)
    {
        if (!isset($this->tables[$name])) {
            $this->tables[$name] = new \Zend_Db_Table(
                $name,
                $this->getDefinition()
            );
        }
        return $this->tables[$name];
    }

    /**
    * table
    *
    * @return mixed
    *
    * @access protected
    */
    protected function table()
    {
        return $this->getTable($this->getEntityName());
    }

    /**
    * find
    *
    * @param mixed $uid DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function find($uid)
    {
        $cols = $this->table()->info('cols');
        if (!is_numeric($uid) && in_array('slug', $cols)) {
            $select = $this->table()->select()
                ->where('slug = ?', $uid);
            $result = $this->table()->fetchAll($select);
        } else {
            $result = $this->table()->find($uid);
        }

        if (! $result) {
            return null;
        }

        if (is_array($uid)) {
            return $result;
        }

        return $result->current();
    }

    /**
    * save
    *
    * @param mixed $entity DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function save($entity)
    {
        $entity->save();
        return $entity;
    }

    /**
    * index
    *
    * @param mixed $request DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function index($request)
    {
        $request;
        $table = $this->table();
        $select = $table->select()
            ->order('created desc');
        return  \Zend_Paginator::factory($select);
    }

    /**
    * delete
    *
    * @param mixed $entity DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function delete($entity)
    {
        return $entity->delete();
    }

    /**
    * factory
    *
    * @param mixed $data DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function factory($data)
    {
        return $this->table()->createRow($data);
    }


}


