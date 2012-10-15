<?php
class JMMCommon {
	public $db;
	public $tbl;
	public $dbname;
	public $action;
	/*################### Print Object ################*/
	function printObj($obj) {
		echo '<pre>';
		print_r($obj);
		echo '</pre><hr />';

	}

	/**
	 * Get Database Default Settings
	 */
	function getDBInstance($driver = null, $host = null, $user = null, $password = null, $dbname = null, $prefix = null) {
		$app = &JFactory::getApplication();

		if (!isset($driver)) {
			$driver = $app -> getCfg('dbtype');
		}
		if (!isset($host)) {
			$host = $app -> getCfg('host');
		}
		if (!isset($user)) {
			$user = $app -> getCfg('user');
		}
		if (!isset($password)) {
			$password = $app -> getCfg('password');
		}
		if (!isset($dbname)) {
			if (isset($_REQUEST['dbname'])) {
				$dbname = JRequest::getVar('dbname');
			} else {
				$dbname = $app -> getCfg('db');
			}

		}
		if (!isset($prefix)) {
			$prefix = $app -> getCfg('dbprefix');
		}

		$option = array();
		$option['driver'] = $driver;
		$option['host'] = $host;
		$option['user'] = $user;
		$option['password'] = $password;
		$option['database'] = $dbname;
		$option['prefix'] = $prefix;
		$db = &JDatabase::getInstance($option);
		return $db;

	}

	/**
	 * Get Tables From Database
	 */
	function getTablesFromDB($db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "SHOW TABLE STATUS";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		$cols = array();
		foreach ($rows as &$row) {
			$cols[] = $row['Name'];
		}
		return $cols;
	}

	/**
	 * Get Cloumn Lists From Tablename
	 */
	function getCloumnsFromTable($table, $db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "SHOW COLUMNS FROM `$table`";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		$cols = array();
		foreach ($rows as &$row) {
			$cols[] = $row['Field'];
		}
		return $cols;
	}

	/**
	 * List Databases
	 */
	 function getDataBaseLists($db = null){
	 	if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "SHOW DATABASES";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		$database=array();
		for ($i = 0; $i < count($rows); $i++) {
			$row = &$rows[$i];
			foreach ($row as $key => &$val) {
				$database[]=$val;
			}
		}
		return $database;
	 }
	 
	/**
	 * Show Databases
	 */

	function showDatabaseLists($db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "SHOW DATABASES";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$row = &$rows[$i];
			foreach ($row as $key => &$val) {
				$val = '<a href="index.php?option=com_jmm&view=tables&dbname=' . $val . '">' . $val . '</a>';
			}
		}
		return $rows;
	}

	/**
	 * Show Tables Lists
	 */
	function showTableLists($db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		if (isset($_REQUEST['dbname'])) {
			$dbname = JRequest::getVar('dbname');
			$urlString = '&dbname=' . $dbname;
		} else {
			$urlString = '';
		}
		$query = "SHOW TABLE STATUS";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		foreach ($rows as &$row) {
			$tblName = $row['Name'];
			$row['Action'] = '<a href="index.php?option=com_jmm&view=tables&action=structure&&tbl=' . $tblName . $urlString . '">Structure</a>';
			$row['Action'] .= '<a href="index.php?option=com_jmm&view=tables&action=browse&&tbl=' . $tblName . $urlString . '">Browse</a>';
			$row['Name'] = '<a href="index.php?option=com_jmm&view=tables&action=browse&tbl=' . $tblName . $urlString . '">' . $tblName . '</a>';
		}

		return $rows;
	}

	/**
	 * Show Table Structure
	 */

	function showTableStructure($table, $db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "DESC $table";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$row = &$rows[$i];
			foreach ($row as $key => &$val) {
				//$row['Browse']='<a href="index.php?option=com_jmm&view=tables&action=structure&&tbl='.$val.'">Edit</a>';
				//$row['Structure']='<a href="index.php?option=com_jmm&view=tables&action=browse&tbl='.$val.'">Delete</a>';
			}
		}
		return $rows;
	}

	/**
	 * Display Data From Table
	 */
	function showDataFromTable($table, $db = null) {
		if (!isset($db)) {
			$db = JMMCommon::getDBInstance();
		}
		$query = "SELECT * FROM $table";
		$db -> setQuery($query);
		$rows = $db -> loadAssocList();
		for ($i = 0; $i < count($rows); $i++) {
			$row = &$rows[$i];
			foreach ($row as $key => &$val) {
				//$row['Browse']='<a href="index.php?option=com_jmm&view=tables&action=structure&&tbl='.$val.'">Edit</a>';
				//$row['Structure']='<a href="index.php?option=com_jmm&view=tables&action=browse&tbl='.$val.'">Delete</a>';
			}
		}
		return $rows;
	}

	/**
	 * Get Model
	 */
	function getModel($modelName, $prefix = null, $backend = true) {
		if (!isset($prefix)) {
			$prefix = 'JMMModel';
		}
		JLoader::import('joomla.application.component.model');
		if ($backend) {
			JLoader::import($modelName, JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jmm' . DS . 'models');
		} else {
			JLoader::import($modelName, JPATH_SITE . DS . 'components' . DS . 'com_jmm' . DS . 'models');
		}
		$model = JModel::getInstance($modelName, $prefix);
		return $model;

	}

}