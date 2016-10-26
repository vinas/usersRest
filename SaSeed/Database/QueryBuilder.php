<?php
/**
* QueryBuilder Class
*
* This class helps the developer to build string queries;
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/25
* @version 1.16.1025
* @license SaSeed\license.txt
*
*/

namespace SaSeed\Database;

use SaSeed\ExceptionHandler;

class QueryBuilder
{
	private $query;
	private $from;
	private $fromAlias;
	private $cols = '*';
	private $joins = '';
	private $conditions = '';
	private $limit = false;
	private $max = false;

	public function getQuery()
	{
		return $this->query;
	}

	public function getFrom()
	{
		return $this->from;
	}

	public function getFromAlias()
	{
		return $this->fromAlias;
	}

	public function getJoins()
	{
		return $this->joins;
	}

	public function getSelect()
	{
		return $this->cols;
	}

	public function getWhere()
	{
		if ($this->conditions != '') {
			return $this->conditions;
		}
		return '1';
	}

	public function getLimit()
	{
		return $this->limit;
	}

	public function getMax()
	{
		return $this->max;
	}

	public function setQuery($query)
	{
		$this->query = $query;
	}

	public function setFrom($from)
	{
		$this->from = $from;
	}

	public function setFromAlias($alias)
	{
		$this->fromAlias = $alias;
	}

	public function setJoins($joins)
	{
		$this->joins = $joins;
	}

	public function setSelect($cols)
	{
		$this->cols = $cols;
	}

	public function setWhere($conditions)
	{
		$this->conditions = $conditions;
	}

	public function setLimit($limit)
	{
		$this->limit = $limit;
	}

	public function setMax($max)
	{
		$this->max = $max;
	}

	public function clearFrom()
	{
		$this->from = null;
	}

	public function clearJoins()
	{
		$this->joins = '';
	}

	public function clearSelect()
	{
		$this->cols = '';
	}

	public function clearWhere()
	{
		$this->conditions = '';
	}

	public function clearQuery()
	{
		$this->query = null;
		$this->from = null;
		$this->fromAlias = null;
		$this->cols = '*';
		$this->joins = '';
		$this->conditions = '';
	}

	public function from($table, $alias = false)
	{
		$this->from = $table;
		if ($alias) {
			$this->from .= ' AS '.$alias;
			$this->fromAlias = $alias;
			return;
		}
		$this->from .= ' AS mainTable';
		$this->fromAlias = 'mainTable';
	}

	public function select($cols)
	{
		if ($cols) {
			$this->addColumnsToSelect($cols);
			return;
		}
		ExceptionHandler::throwAppException(__CLASS__, __FUNCTION__, 'Error: No columns sent.');
	}

	public function join($joinTable, $joinCol, $comp, $compCol, $compAlias = false)
	{
		if (is_array($joinTable)) {
			$this->joins .= 'INNER JOIN '.$joinTable[0].' AS '.$joinTable[1].' ON '.$joinTable[1].'.'.$joinCol.' '.$comp.' ';
			$this->joins .= ($compAlias) ? $compAlias : $this->fromAlias;
			$this->joins .= '.'.$compCol;
			return;
		}
		ExceptionHandler::throwAppException(__CLASS__, __FUNCTION__, 'Error: Invalid table. First argument (joined table) must be sent as an array: [name, alias].');
	}

	public function where($clause)
	{
		if (is_array($clause)) {
			if ($this->conditions != '')
				$this->conditions .= ' AND ';
			$this->conditions .= $clause[0].'.'.$clause[1].' '.$clause[2].' '.$clause[3];
			return;
		}
		ExceptionHandler::throwAppException(__CLASS__, __FUNCTION__, 'Error: Invalid where clause. It must be sent as an array: [column, coparisson, value].');
	}

	public function orWhere($clause)
	{
		if (is_array($clause)) {
			$this->conditions .= ' OR '.$this->fromAlias.'.'.$clause[0].' '.$clause[1].' '.$clause[2];
			return;
		}
		ExceptionHandler::throwAppException(__CLASS__, __FUNCTION__, 'Error: Invalid where clause. It must be sent as an array: [column, coparisson, value].');
	}
	public function buildQuery()
	{
		$this->query = 'SELECT '.$this->cols.' FROM '.$this->from.' '.$this->joins.' WHERE '.$this->getWhere();
	}

	private function addColumnsToSelect($cols)
	{
		if ($this->cols == '*')
			$this->cols = '';
		if ($cols == '*') {
			$this->cols = '*';
			return;
		}
		if (is_string($cols)) {
			if ($this->cols != '')
				$this->cols .= ', ';
			$this->cols .= $cols;
			return;
		}
		if (is_array($cols)) {
			foreach ($cols as $col) {
				if ($this->cols != '')
					$this->cols .= ', ';
				if (is_array($col)) {
					$this->cols .= $col[0] . ' AS ' .$col[1];
					continue;
				}
				$this->cols .= $col;
			}
			return;
		}
		ExceptionHandler::throwAppException(__CLASS__, __FUNCTION__, 'Error: Invalid columns sent.');
	}

}
