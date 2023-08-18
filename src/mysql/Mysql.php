<?php
/**
 * Copyright (c) Vojin Petrovic. All rights reserved.
 */

namespace VoxxxUtils\mysql;

use mysqli;
use mysqli_result;
use mysqli_sql_exception;

class Mysql {
	private mysqli $conn;
	private array $recordSet = [];
	private int $affected_rows = 0;
	private int $lastId = 0;

	public function __construct(MysqlConnection $connection) {
		$this->conn = mysqli_connect($connection->host, $connection->user, $connection->pass, $connection->dbname, $connection->port);
		$this->conn->query("SET NAMES 'utf8';");
	}

	function open($server, $user, $pass, $table, $port): void {
		$this->conn = mysqli_connect($server, $user, $pass, $table, $port);
		$this->conn->query("SET NAMES 'utf8';");
	}

	function close(): void {
		$this->conn->close();
	}

	public function insert($table, $columns, $values): int {
		if (is_array($columns) && is_array($values)) {
			$allcolumns = [];
			$allvalues = [];
			for ($i = 0; $i < count($columns); $i++) {
				$allcolumns[] = "`" . $columns[$i] . "`";
			}
			for ($i = 0; $i < count($values); $i++) {
				$allvalues[] = "'" . $this->safeValue($values[$i]) . "'";
			}
			$sql = "INSERT INTO `" . $table . "` (" . implode(",", $allcolumns) . ") VALUES (" . implode(",", $allvalues) . ")";
		} else {
			$sql = "INSERT INTO `" . $table . "` (`" . $columns . "`) VALUES ('" . $this->safeValue($values) . "')";
		}
		$this->lastId = $this->executeInsertQuery($sql);
		return $this->lastId;
	}

	public function insert_multi($table, $columns, $values, $maxItems = 0): int {
		$allcolumns = [];
		for ($i = 0; $i < count($columns); $i++) {
			$allcolumns[] = "`" . $columns[$i] . "`";
		}
		$allcolumnsStr = implode(",", $allcolumns);
		$sqlInitial = "INSERT INTO `" . $table . "` (" . $allcolumnsStr . ") VALUES ";

		$slqsins = [];
		foreach ($values as $value) {
			$ivalues = [];
			for ($i = 0; $i < count($value); $i++) {
				$ivalues[] = "'" . $this->safeValue($value[$i]) . "'";
			}
			$slqsins[] = "(" . implode(", ", $ivalues) . ")";
			if ($maxItems > 0) {
				if (count($slqsins) >= $maxItems) {
					$sql = $sqlInitial . implode(", ", $slqsins);
					$this->lastId = $this->executeInsertQuery($sql);
					$slqsins = [];
				}
			}
		}
		if (count($slqsins) > 0) {
			$sql = $sqlInitial . implode(",", $slqsins);
			$this->lastId = $this->executeInsertQuery($sql);
		}
		return $this->lastId;
	}

	public function update(string $table, array|string $columns, mixed $values, int $id, $idcol = "id"): void {
		if (is_array($columns) && is_array($values)) {
			$sql = "UPDATE `" . $table . "` SET ";
			$ivalues = [];
			for ($i = 0; $i < count($columns); $i++) {
				$ivalues[] = "`" . $columns[$i] . "` = '" . $this->safeValue($values[$i]) . "'";
			}
			$sql .= implode(", ", $ivalues) . " WHERE `" . $idcol . "` = '" . $id . "';";
		} else {
			$sql = "UPDATE `" . $table . "` SET `" . $columns . "`='" . $this->safeValue($values) . "' WHERE `" . $idcol . "` = '" . $id . "';";
		}
		$this->executeUpdateQuery($sql);
	}

	public function updateWhere(string $table, array|string $columns, mixed $values, string $where): void {
		if (is_array($columns) && is_array($values)) {
			$sql = "UPDATE `" . $table . "` SET ";
			$ivalues = [];
			for ($i = 0; $i < count($columns); $i++) {
				$ivalues[] = "`" . $columns[$i] . "` = '" . $this->safeValue($values[$i]) . "'";
			}
			$sql .= implode(", ", $ivalues) . " WHERE " . $where . ";";
		} else {
			$sql = "UPDATE `" . $table . "` SET `" . $columns . "`='" . $this->safeValue($values) . "' WHERE " . $where . ";";
		}
		$this->executeUpdateQuery($sql);
	}

	public function delete(string $table, int $id): void {
		$sql = "DELETE FROM `" . $table . "` WHERE `id` = '" . $id . "';";
		$this->executeUpdateQuery($sql);
	}

	public function deletewhere(string $table, string $where): void {
		$sql = "DELETE FROM `" . $table . "` WHERE " . $where . ";";
		$this->executeUpdateQuery($sql);
	}

	public function tablecount(string $table, string $where = "") {
		$sql = "SELECT count(*) as CNT FROM `" . $table . "`" . ($where != "" ? " WHERE " . $where : '');
		return $this->singleValue($sql, "CNT");
	}

	public function tablecountsql(string $sql) {
		return $this->singleValue($sql, "CNT");
	}

	function safeValue(string $str): string {
		return mysqli_real_escape_string($this->conn, $str);
	}

	/***************************************************************/

	function read(string $sql, int $b = 1): void {
		$this->executeReadQuery($sql, $b);
	}

	function readArray($sql): mysqli_result|bool {
		return $this->executeSelectQuery($sql);
	}

	function readTable(string $table, $where = "", $group = "", $order = "", $id = ""): array {
		$sql = "select * from `" . $table . "`";
		if ($where != "")
			$sql .= " where " . $where;
		if ($group != "")
			$sql .= " group by " . $group;
		if ($order != "")
			$sql .= " order by " . $order;
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		foreach ($r as $row) {
			if ($id == "") {
				$ret[] = $row;
			} else {
				$ret[$row[$id]] = $row;
			}
		}
		return $ret;
	}

	function readTableSingleValues($table, $column, $where = "", $group = "", $order = ""): array {
		$sql = "select * from `" . $table . "`";
		if ($where != "")
			$sql .= " where " . $where;
		if ($group != "")
			$sql .= " group by " . $group;
		if ($order != "")
			$sql .= " order by " . $order;
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		foreach ($r as $row) {
			$ret[] = $row[$column];
		}
		return $ret;
	}

	function readTableSingleValuesSql($sql, $column): array {
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		foreach ($r as $row) {
			$ret[] = $row[$column];
		}
		return $ret;
	}

	function readTableSingleValuesSqlWithId($sql, $column): array {
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		$ret[0] = "";
		foreach ($r as $row) {
			$ret[$row['id']] = $row[$column];
		}
		return $ret;
	}

	function readTableSql($sql, $id = ""): array {
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		foreach ($r as $row) {
			if ($id == "")
				$ret[] = $row;
			else
				$ret[$row[$id]] = $row;
		}
		return $ret;

	}

	function readTableIds($sql, $id = "id"): array {
		$ret = [];
		$r = $this->executeSelectQuery($sql);
		foreach ($r as $row) {
			$ret[] = $row[$id];
		}
		return $ret;

	}

	function singleRow($sql): bool|array|null {
		$r = $this->executeSelectQuery($sql);
		return @mysqli_fetch_assoc($r);
	}

	function singleRowWhere($table, $where = "", $order = "", $what = "*"): bool|array|null {
		$sql = "select " . $what . " from `" . $table . "`";
		if ($where != "")
			$sql .= " where " . $where;
		if ($order != "")
			$sql .= " order by " . $order;
		$sql .= " limit 1";
		$r = $this->executeSelectQuery($sql);
		return mysqli_fetch_assoc($r);
	}

	function singleValue($sql, $column) {
		$r = $this->executeSelectQuery($sql);
		$row = mysqli_fetch_assoc($r);
		return ($row[$column] ?? ($column == "id" ? 0 : ''));
	}


	function fetch($b = 1): bool|array|null {
		return mysqli_fetch_assoc($this->recordSet[$b]);
	}

	public function store($sql): void {
		$this->executeUpdateQuery($sql);
	}

	/***********************/
	private function executeInsertQuery(string $sql): int {
		try {
			$this->conn->query($sql);
			return mysqli_insert_id($this->conn);
		} catch (mysqli_sql_exception) {
			$this->showError($sql, mysqli_error($this->conn));
		}

	}

	private function executeUpdateQuery(string $sql): void {
		try {
			$this->conn->query($sql);
			$this->affected_rows = mysqli_affected_rows($this->conn);
		} catch (mysqli_sql_exception) {
			$this->showError($sql, mysqli_error($this->conn));
		}

	}

	private function executeSelectQuery(string $sql): mysqli_result {
		try {
			$r = $this->conn->query($sql);
			if (!$r)
				$this->showError($sql, mysqli_error($this->conn));
			return $r;
		} catch (mysqli_sql_exception) {
			$this->showError($sql, mysqli_error($this->conn));
		}

	}

	private function executeReadQuery(string $sql, int $b = 1): void {
		try {
			$this->recordSet[$b] = $this->conn->query($sql);
			if (!$this->recordSet[$b])
				$this->showError($sql, mysqli_error($this->conn));
		} catch (mysqli_sql_exception) {
			$this->showError($sql, mysqli_error($this->conn));
		}

	}

	function showError(string $statement, ?string $error): void {
		throw new mysqli_sql_exception("There was an error in querying database. Query: " . $statement . "Error: " . $error);
	}

}
