<?php
/**
 * EReCaptcha class file.
 *
 * @author Konstantin Mirin
 * @link http://programmersnotes.info/
 * @copyright Copyright &copy; 2009 Konstantin Mirin
 * @license
 *
 * Copyright © 2009 by Konstantin Mirin
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - Neither the name of MetaYii nor the names of its contributors may
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/**
 * XDbParam handles application parameters using DB
 *
 * @author Konstantin Mirin
 * @package application.extensions.dbparam
 * @version 2.0
 */
class XDbParam extends CAttributeCollection implements IApplicationComponent
{
	/**
	 * @var string the ID of the {@link CDbConnection} application component. If not set,
	 * a SQLite3 database will be automatically created and used. The SQLite database file
	 * is <code>protected/runtime/params-YiiVersion.db</code>.
	 */
	public $connectionID;
	/**
	 * @var string name of the DB table to store cache content. Defaults to 'YiiParams'.
	 * Note, if {@link autoCreateParamsTable} is false and you want to create the DB table
	 * manually by yourself, you need to make sure the DB table is of the following structure:
	 * <pre>
	 * (name CHAR(128) PRIMARY KEY, value BLOB)
	 * </pre>
	 * Note, some DBMS might not support BLOB type. In this case, replace 'BLOB' with a suitable
	 * binary data type (e.g. LONGBLOB in MySQL, BYTEA in PostgreSQL.)
	 * @see autoCreateCacheTable
	 */
//	public $paramsTableName='XParams';
	public $paramsTableName='parameter';
	/**
	 * @var boolean whether the cache DB table should be created automatically if it does not exist. Defaults to true.
	 * @see paramsTableName
	 */
	public $autoCreateParamsTable=true;
	/**
	 * If all parameters should be loaded by default
	 *
	 * @var bool
	 */
	public $autoLoad = false;
	/**
	 * Array or comma-separated string of parameters to load anyway
	 *
	 * @var array
	 */
	public $preload;
	/**
	 * Array of already loaded parameters
	 *
	 * @var array
	 */
	protected $cache;
	/**
	 * @var CDbConnection the DB connection instance
	 */
	protected $_db;
	/**
	 * If component is initialized
	 *
	 * @var bool
	 */
	protected $_init = false;

	//
	public $createTable = false;
	
	/**
	 * Returns if component is initialized
	 *
	 * @return bool
	 */
	public function getIsInitialized()
	{
		return $this->_init;
	}
	
	/**
	 * Initializes component, creates table if it doesn't exist and populates preloaded attributes
	 * @throws CException Throws exception if table does not exist and auto creation is set to false
	 */
	public function init()
	{
		$this->_init = true;
		$db = $this->getDbConnection();
		$this->preload = $this->preprocessParams($this->preload);
		if (!empty($this->preload) || $this->autoLoad)
		{
			$sql = 'SELECT name, value FROM '.$this->paramsTableName;
			if (sizeof($this->preload))
				$sql .= ' WHERE name IN (\''.implode('\',\'', $this->preload).'\')';
			$cmd = $db->createCommand($sql);
			try 
			{
				$reader = $cmd->query();
				foreach ($reader as $row) 
				{
					$this->add($row['name'], $row['value']);
				}
			}
			catch (CException $e)
			{
				//table is not present
				$createTable = true;
				//if there is no table, then attributes are empty.
				for ($i = 0, $s = sizeof($this->preload); $i < $s; $i++)
				{
					$this->add($this->preload[$i], null);
				}
			}
		}
		else 
		{
			//check if table exist
			//if ($db->createCommand('SHOW TABLES LIKE \''.$this->paramsTableName.'\'')->query()->rowCount <= 0)
			//	$createTable = true;
				$createTable = false;
		}
				$createTable = false;
		if ($createTable === true)
		{
			if($this->autoCreateParamsTable)
				$this->createParamsTable($db,$this->paramsTableName);
			else
				throw new CException(Yii::t('xparam','Params table "{tableName}" does not exist.',
					array('{tableName}'=>$this->paramsTableName)));
		}
	}
	
	/**
	 * Creates the params DB table.
	 * @param CDbConnection the database connection
	 * @param string the name of the table to be created
	 */
	protected function createParamsTable($db,$tableName)
	{
		$driver=$db->getDriverName();
		if($driver==='mysql')
			$blob='LONGBLOB';
		else if($driver==='pgsql')
			$blob='BYTEA';
		else
			$blob='BLOB';
		$sql=<<<EOD
CREATE TABLE $tableName
(
	name CHAR(128) PRIMARY KEY,
	value $blob
)
EOD;
		$db->createCommand($sql)->execute();
	}
	
	/**
	 * @return CDbConnection the DB connection instance
	 * @throws CException if {@link connectionID} does not point to a valid application component.
	 */
	protected function getDbConnection()
	{
		if($this->_db!==null)
			return $this->_db;
		else if(($id=$this->connectionID)!==null)
		{
			if(($this->_db=Yii::app()->getComponent($id)) instanceof CDbConnection)
				return $this->_db;
			else
				throw new CException(Yii::t('xparam','XDbParam.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.',
					array('{id}'=>$id)));
		}
		else
		{
			$dbFile=Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'params-'.Yii::getVersion().'.db';
			return $this->_db=new CDbConnection('sqlite:'.$dbFile);
		}
	}
	
	/**
	 * Returns parameter from DB or cache if it was requested earlier
	 *
	 * @param string $name
	 */
	protected function loadParam($name)
	{
		if (!$this->caseSensitive)
			$name = strtolower($name);
		$db = $this->getDbConnection();
		$res = $db->createCommand('SELECT value FROM '.$this->paramsTableName.' WHERE name=\''.$name.'\'')->query();
		// Assuming that SQLite does not return meaningful number in "rowCount". 
		// Since drop the sanity check and rely on the admin.
		//if ($res->rowCount == 1)
		//{
			$row = $res->read();
			$this->add($name,$row['value']);
			return $row['value'];
		//}
		//else
		//{
		//	throw new CException(Yii::t('xparam','XDbParam->{name} does not exist!',
		//		array('{name}'=>$name)));
		//}
	}
	
	/**
	 * Processes param names, extracts them from comma-separtated string or array,
	 * converts to lowercase
	 *
	 * @param string|array $params
	 * @return array
	 */
	protected function preprocessParams($params)
	{
		if (is_string($params))
		{
			$params = explode(',', $params);
			for ($i = 0, $s = sizeof($params); $i < $s; $i++)
			{
				$params[$i] = trim($params[$i]);
			}
		}
		if ($this->caseSensitive === false)
		{
			for ($i = 0, $s = sizeof($params); $i < $s; $i++)
			{
				$params[$i] = strtolower($params[$i]);
			}
		}
		return $params;
	}
	
	/**
	 * Returns a property value or an event handler list by property or event name.
	 * This method overrides the parent implementation by returning
	 * a parameter value if the it exist in the collection or loading it from DB
	 * if not.
	 * 
	 * @param string the property name or the event name
	 * @return mixed the property value or the event handler list
	 * @throws CException if the property/event is not defined.
	 */
	public function __get($name)
	{
		if($this->contains($name))
			return $this->itemAt($name);
		else
		{
			try 
			{
				return $this->loadParam($name);
			}
			catch (CException $e)
			{
				return parent::__get($name);
			}
		}
	}
	
	/**
	 * Sets value of a component property.
	 * This method overrides the parent implementation by adding a new param
	 * value to the collection and updating the DB.
	 * @param string the property name or event name
	 * @param mixed the property value or event handler
	 * @throws CException If the property is not defined or read-only.
	 */
	public function __set($name,$value)
	{
		if (!$this->caseSensitive)
			$name = strtolower($name);
		$db = $this->getDbConnection();
		if ($db->createCommand('SELECT name FROM '.$this->paramsTableName.' WHERE name=\''.$name.'\'')->query()->rowCount >= 1)
		{
			$sql = 'UPDATE `'.$this->paramsTableName.'` SET `value`=:value WHERE `name`=:name';
			$cmd = $db->createCommand($sql);
			$cmd->bindValue(':value', $value, PDO::PARAM_LOB);
			$cmd->bindValue(':name', $name, PDO::PARAM_STR);
		}
		else 
		{
			$sql = 'INSERT INTO `'.$this->paramsTableName.'`(name, value) VALUES(:name, :value)';
			$cmd = $db->createCommand($sql);
			$cmd->bindValue(':name', $name, PDO::PARAM_STR);
			$cmd->bindValue(':value', $value, PDO::PARAM_LOB);
		}
		$cmd->execute();
		$this->add($name,$value);
	}
	
	/**
	 * Loads several params from DB at once. If nothing specified, all parameters
	 * are loaded. This saves queries if you plan to use all that params in the 
	 * next lines.
	 *
	 * @param array|string $params
	 * @throws CException
	 */
	public function load($params = array())
	{
		$params = $this->preprocessParams($params);
		$db = $this->getDbConnection();
		$sql = 'SELECT name, value FROM '.$this->paramsTableName;
		if (sizeof($params) > 0)
		{
			$sql .= ' WHERE name IN (\''.implode('\',\'', $params).'\')';
		}
		$cmd = $db->createCommand($sql);
		$reader = $cmd->query();
		foreach ($reader as $row) 
		{
			$this->add($row['name'], $row['value']);
			$loaded++;
		}
		if ($loaded < sizeof($params))//this will not be thrown if loading all attributes
		{
			throw new CException(Yii::t('xparam','Some of the requested params do not exist!'));
		}
	}
	
	/**
	 * Deletes specified params (or all params if none specified) from the parameters table
	 *
	 * @param array|string $params Comma-separated list of params or array of param names
	 */
	public function purge($params = array())
	{
		$sql = 'DELETE FROM '.$this->paramsTableName;
		if (sizeof($params) > 0)
		{
			$params = $this->preprocessParams($params);
			$sql .= ' WHERE name IN (\''.implode('\',\'', $params).'\')';
		}
		$db = $this->getDbConnection();
		$db->createCommand($sql)->execute();
		if (sizeof($params) > 0)
		{
			for ($i = 0, $s = sizeof($params); $i < $s; $i++)
			{
				$this->remove($params[$i]);
			}
		}
		else 
			$this->clear();
	}
}
?>
