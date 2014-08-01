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
 * @package   Model
 * @author    Jake Johns <jake@jakejohns.net>
 * @copyright 2014 Jake Johns
 * @license   http://www.gnu.org/licenses/gpl-3.0.txt GPL V3
 * @link      http://jakejohns.net
 */

namespace Jnzf1\Auth;

/**
 * UserModel
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
 */
class UserModel
{

    /**
     * userTable
     *
     * @var Zend_Db_Table
     * @access protected
     */
    protected $userTable;

    /**
     * salt
     *
     * @var string
     * @access protected
     */
    protected $salt = 'ugsOdOlt0wrackBynViezNaymyejagyift';


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
        $this->userTable = new \Zend_Db_Table('user');
    }


    /**
    * index
    *
    * gets all users
    *
    * @return Zend_Paginator
    *
    * @access public
    */
    public function index()
    {
        $select = $this->userTable->select()
            ->order('uid ASC');
        return \Zend_Paginator::factory($select);
    }

    /**
    * authenticate
    *
    * authenticates a user
    *
    * @param array $data posted form data for auth
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function authenticate(array $data)
    {
        $adapter = new \Zend_Auth_Adapter_DbTable(
            $this->userTable->getAdapter(),
            $this->userTable->info('name'),
            'email',
            'hash',
            sprintf('SHA1(CONCAT(?, salt, "%s"))', $this->salt)
        );

        $adapter->setIdentity($data['username']);
        $adapter->setCredential($data['password']);

        $auth = \Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);

        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()
                ->write($user);
        }

        return $result;
    }

    /**
    * find
    *
    * gets a user entry
    *
    * @param mixed $uid uniquie numeric identifier
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function find($uid)
    {
        $result = $this->userTable->find($uid);
        if ($result) {
            return $result->current();
        }
        return false;
    }

    /**
    * update
    *
    * updaates a user record
    *
    * @param mixed $uid  DESCRIPTION
    * @param mixed $data DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function update($uid, $data)
    {
        $user = $this->find($uid);

        if ($data['password']) {
            $data = array_merge(
                $data,
                $this->passwordData($data['password'])
            );
            unset($data['password']);
        }

        $user->setFromArray($data);
        return $user->save();
    }

    /**
    * create
    *
    * create a user account
    *
    * @param mixed $data DESCRIPTION
    *
    * @return mixed
    *
    * @access public
    */
    public function create($data)
    {
        $data = array_merge(
            $data,
            $this->passwordData($data['password'])
        );
        unset($data['password']);

        $uid = $this->userTable->insert($data);
        return $this->find($uid);
    }


    /**
    * verify
    *
    * checks password for curent identity
    *
    * @param mixed $password DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function verify($password)
    {
        $identity = \Zend_Auth::getInstance()->getIdentity();
        $hash = sha1(
            $password
            . $identity->salt
            . $this->salt
        );
        return ($identity->hash === $hash);
    }

    /**
    * changePassword
    *
    * change current user password
    *
    * @param mixed $password DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access public
    */
    public function changePassword($password)
    {
        $identity = \Zend_Auth::getInstance()->getIdentity();
        $user = $this->find($identity->uid);
        $data = $this->passwordData($password);
        $user->setFromArray($data);
        return $user->save();
    }

    /**
    * passwordData
    *
    * gets new salt and hash
    *
    * @param mixed $password DESCRIPTION
    *
    * @return mixed
    * @throws exceptionclass [description]
    *
    * @access protected
    */
    protected function passwordData($password)
    {
        $data = array();
        $data['salt'] = sha1(
            time()
            . str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
        );

        $data['hash'] = sha1(
            $password
            . $data['salt']
            . $this->salt
        );

        return $data;
    }


}


