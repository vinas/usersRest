class QueryBuilder
{
	private $query;
	private $table;
	private $tableAlias;
	private $cols = '';
	private $joins = '';
	private $conditions = '';

	public function getQuery()
	{
		return $this->query;
	}

	public function getTable()
	{
		return $this->table;
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
		return $this->conditions;
	}

	public function setQuery($query)
	{
		$this->query = $query;
	}

	public function setTable($table)
	{
		$this->table = $table;
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

	public function clearTable()
	{
		$this->table = null;
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
		$this->table = null;
		$this->tableAlias = null;
		$this->cols = '';
		$this->joins = '';
		$this->conditions = '';
	}

	public function table($table, $alias = false)
	{
		$this->table = $table;
		if ($alias) {
			$this->table .= ' AS '.$alias;
			$this->tableAlias = $alias;
			return;
		}
		$this->table .= ' AS mainTable';
		$this->tableAlias = 'mainTable';
	}

	public function select($cols)
	{
		if ($cols) {
			$this->addColumnsToSelect($cols);
			return;
		}
		echo 'Error: Invalid columns sent.';
	}

	public function join($joinTable, $joinCol, $comp, $compCol, $compAlias = false)
	{
		if (is_array($joinTable)) {
			$this->joins .= 'INNER JOIN '.$joinTable[0].' AS '.$joinTable[1].' ON '.$joinTable[1].'.'.$joinCol.' '.$comp.' ';
			$this->joins .= ($compAlias) ? $compAlias : $this->tableAlias;
			$this->joins .= '.'.$compCol;
			return;
		}
		echo 'Error: Invalid table. First argument (joined table) must be sent as an array: [name, alias].';
	}

	public function where($clause)
	{
		if (is_array($clause)) {
			if ($this->conditions != '')
				$this->conditions .= ' AND ';
			$this->conditions .= $this->tableAlias.'.'.$clause[0].' '.$clause[1].' '.$clause[2];
			return;
		}
		echo 'Error: Invalid where clause. It must be sent as an array: [column, coparisson, value].';
	}

	public function buildQuery()
	{
		$this->query = 'SELECT '.$this->cols.' FROM '.$this->table.' '.$this->joins.' WHERE ';
		if ($this->conditions) {
			$this->query .= $this->conditions;
			return;
		}
		$this->query .= '1';

	}

	private function addColumnsToSelect($cols)
	{
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
		echo 'Error: Invalid columns sent.';
	}

}
