<?php
defined('ALE_BASE') or die('Restricted access');

require_once ALE_BASE.DIRECTORY_SEPARATOR.'interface'.DIRECTORY_SEPARATOR.'cache.php';

require_once ALE_BASE.DIRECTORY_SEPARATOR.'exception'.DIRECTORY_SEPARATOR.'cache.php';

abstract class AleCacheAbstractDB implements AleInterfaceCache {
	protected $db;
	protected $table;
	protected $host;
	protected $path;
	protected $paramsRaw;
	protected $params;
	
	protected $row;
	
	function __construct(array $config = array()) {
		$this->table = $this->_($config, 'table', 'alecache');
	}
	
	abstract protected function escape($string);
	
	abstract protected function &execute($query);
	
	abstract protected function &fetchRow(&$result);
	
	abstract protected function freeResult(&$result);
	
	protected function _(&$array, $name, $default = null) {
		return isset($array[$name]) ? $array[$name] : $default;
	}
	
	protected function getWhere() {
		$result = '';
		foreach (array('host', 'path', 'params') as $field) {
			if ($result) {
				$result .= ' AND ';
			}
			$result .= sprintf("%s = '%s'", $field, $this->escape($this->$field));
		}
		return $result;
		
	}
	
	public function setHost($host) {
		$this->host = $host;
	}
	
	/**
	 * Set call parameters
	 *
	 * @param string $path
	 * @param array $params
	 */
	public function setCall($path, array $params = array()) {
		$this->path = $path;
		$this->paramsRaw = $params;
		$this->params = sha1(http_build_query($params, '', '&'));
		
		$query = sprintf("SELECT * FROM %s WHERE %s", $this->table, $this->getWhere());
		$result = $this->execute($query);
		$this->row = $this->fetchRow($result);
		$this->freeResult($result);
	}
	
	/**
	 * Store content
	 *
	 * @param string $content
	 * @param string $cachedUntil
	 * @return null
	 */
	public function store($content, $cachedUntil) {
		
		if ($this->row) {
			$this->row['content'] = $content;
			$this->row['cachedUntil'] = $cachedUntil;
			$content = "'".$this->escape($content)."'";
			$cachedUntil = $cachedUntil ? "'".$this->escape($cachedUntil)."'" : 'NULL';
			$query = sprintf('UPDATE %s SET content = %s, cachedUntil =  %s  WHERE %s', 
				$this->table, $content, $cachedUntil, $this->getWhere());
		} else {
			$this->row = array();
			$this->row['content'] = $content;
			$this->row['cachedUntil'] = $cachedUntil;
			foreach (array('host', 'path', 'params') as $field) {
				$this->row[$field] = $this->$field;
			}
			$fields = array();
			$values = array();
			foreach ($this->row as $field => $value) {
				$fields[] = $field;
				$values[] = $value ? "'".$this->escape($value)."'" : 'NULL';
			}
			$query = sprintf('INSERT INTO %s (%s) VALUES (%s);', 
				$this->table, implode(', ', $fields), implode(', ', $values));
		}
		$this->execute($query);
	}
	
	/**
	 * Update cachedUntil value of recent call
	 *
	 * @param string $time
	 */
	public function updateCachedUntil($time) {
		if ($this->row) {
			$this->row['cachedUntil'] = $time;
			$cachedUntil = $time ? "'".$this->escape($time)."'" : 'NULL';
			$query = sprintf('UPDATE %s SET cachedUntil = %s  WHERE %s', 
				$this->table, $cachedUntil, $this->getWhere());
			$this->execute($sql);
		}
			
	}
	
	/**
	 * Retrieve content as string
	 *
	 */
	public function retrieve() {
		if ($this->row) {
			return $this->row['content'];
		}
		return null;
	}
	
	/**
	 * Check if target is stored  
	 *
	 * @return int|null
	 */
	public function isCached() {
		if ($this->row == false) {
			return ALE_CACHE_MISSING;	
		}
		
		$tz = new DateTimeZone('UTC');
		$now = new DateTime(null, $tz);
		$cachedUntlil = new DateTime($this->row['cachedUntil'], $tz);
		
		if ((int) $cachedUntlil->format('U') < (int) $now->format('U')) {
			return ALE_CACHE_EXPIRED;
		}
		
		return ALE_CACHE_CACHED;
		
	}
	
}