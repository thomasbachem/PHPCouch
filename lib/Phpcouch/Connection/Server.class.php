<?php

class PhpcouchServerConnection extends PhpcouchConnection
{
	/**
	 * Build a URI from the given information.
	 *
	 * @param      array An array of additional arguments to set in the URL.
	 *
	 * @return     string A generated URL.
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	protected function buildUri(array $info = array())
	{
		return $this->baseUrl . (isset($info['database']) ? $info['database'] : '');
	}
	
	/**
	 * Create a new database on the server.
	 *
	 * @param      string The name of the database to create.
	 *
	 * @throws     ?
	 *
	 * @author     David Zülke
	 * @since      1.0.0
	 */
	public function createDatabase($name)
	{
		// result doesn't matter here
		$this->adapter->put($this->buildUri(array('database' => $name)));
		// and return a proper instance just for kicks
		return $this->retrieveDatabase($name);
		// TODO: catch exceptions?
	}
	
	/**
	 * Retrieve database information from the server.
	 *
	 * @param      string The database name.
	 *
	 * @return     PhpcouchDatabase The database instance.
	 *
	 * @throws     ?
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function retrieveDatabase($name)
	{
		// TODO: catch exceptions
		$result = $this->adapter->get($this->buildUri(array('database' => $name)));
		$database = new PhpcouchDatabase();
		$database->hydrate($result);
		return $database;
	}
	
	/**
	 * Delete a database from the server.
	 *
	 * @param      string The name of the database to delete.
	 *
	 * @throws     ?
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      1.0.0
	 */
	public function deleteDatabase($name)
	{
		// TODO: catch exceptions
		$result = $this->adapter->delete($this->buildUri(array('database' => $name)));
		return $result;
	}
	
	/**
	 * List all databases on the server.
	 *
	 * @return     array An array of database names.
	 *
	 * @throws     ?
	 *
	 * @author     David Zülke <dz@bitxtender.com>
	 * @since      0.11.0
	 */
	public function listDatabases()
	{
		// TODO: catch exceptions?
		return $this->adapter->get($this->buildUri(array('database' => '_all_dbs')));
	}
}

?>