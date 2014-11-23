<?php

namespace LookupTest\Db;

use PHPUnit_Framework_TestCase;
use Zend\Db\Adapter\Adapter;

class BaseTestCase extends PHPUnit_Framework_TestCase
{
	protected function createTables(Adapter $adapter)
	{
		$schema = file_get_contents(__DIR__ . '/../../../../../scripts/schemata/schema.sqlite3.sql');
		$statements = explode(';', $schema);
		foreach ($statements as $statement) {
			$sql = trim($statement);
			if (empty($sql)) {
				continue;
			}
			$adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);
		}
	}
}
