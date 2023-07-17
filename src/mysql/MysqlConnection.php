<?php

namespace VoxxxUtils\mysql;

class MysqlConnection {
	public string $host;
	public string $user;
	public string $pass;
	public string $dbname;
	public int $port;

	/**
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $dbname
	 * @param int $port
	 */
	public function __construct(string $host, string $user, string $pass, string $dbname, int $port = 3306) {
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->dbname = $dbname;
		$this->port = $port;
	}

}