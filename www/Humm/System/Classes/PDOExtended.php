<?php

/**
 * This file implement the PDOExtended system class.
 *
 * Humm PHP use this class internally from the Database
 * class in order to work with databases. Site classes,
 * views and plugins must use the Database instead this.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://github.com/dec/hummphp-8/blob/main/LICENSE
 * @copyright (C) Humm PHP - DecSoft Utils
 */

declare (strict_types = 1);

namespace Humm\System\Classes;

/**
 * System PDOExtended class implementation.
 *
 * This class are used internally by the Database class,
 * which is the recommended way to work with databases
 * from site classes, views and plugins.
 *
 */
class PDOExtended extends \PDO {

  /**
   * Define the default PHP class to fetch results.
   */
  private const DEFAULT_FETCH_CLASS = '\StdClass';

  /**
   * Last executed SQL statement.
   *
   * @var PDOStatement
   */
  protected ?\PDOStatement $statement = null;

  /**
   * Fetch mode currently established.
   *
   * @var int
   */
  protected int $fetch_mode = parent::FETCH_CLASS;

  /**
   * Fetch class currently established.
   *
   * @var string
   */
  protected string $fetch_class = self::DEFAULT_FETCH_CLASS;

  /**
   * Construct a PDOExtended object.
   *
   * @param string $dsn Database connection string.
   * @param ?string $user Database user name.
   * @param ?string $password Database user password.
   * @param ?array $options Database connection options.
   */
  public function __construct (string $dsn, ?string $user = null, ?string $password = null, ?array $options = null) {

    parent::__construct($dsn, $user, $password, $options);

    parent::setAttribute(parent::ATTR_ERRMODE, parent::ERRMODE_EXCEPTION);
  }

  /**
   * Get an specific record field value.
   *
   * <code>
   *   // Get the text of a note with id = 1 (using value)
   *   Database::getValue
   *   (
   *     'SELECT text FROM notes WHERE id = ?',
   *     [1]
   *   );
   *
   *   // Get the text of a note with id = 1 (using binded param)
   *   Database::getValue
   *   (
   *     'SELECT text FROM notes WHERE id = :id',
   *     ['id' => 1]
   *   );
   * </code>
   *
   * @param string $sql_query SQL statement to be prepared and executed.
   * @param array $params SQL statement arguments.
   * @return mixed Value of the specified record field or null if not found.
   */
  public function getValue (string $sql_query, array $params = []) : mixed {

    $result = null;

    if ($this->_query($sql_query, $params)) {

      $fetch = $this->statement->fetch(parent::FETCH_NUM);

      if (isset($fetch[0])) {

        $result = $fetch[0];
      }
    }

    return $result;
  }

  /**
   * Get record fields as key and value pairs.
   *
   * <code>
   *   // Get date (as key) and text (as value) note with id = 1
   *   Database::getPair
   *   (
   *     'SELECT date, text FROM notes WHERE id = ?', [1]
   *   );
   *
   *   // Get date (as key) and text (as value) note with id = 1
   *   Database::getPair
   *   (
   *     'SELECT date, text FROM notes WHERE id = :id', ['id' => 1]
   *   );
   * </code>
   *
   * @param string $sql_query SQL statement to be prepared and executed.
   * @param array $params SQL statement parameters.
   * @return array Record field keys and values pairs.
   */
  public function getPair (string $sql_query, array $params = []) : array {

    $result = [];

    if ($this->_query($sql_query, $params)) {

      $results = $this->statement->fetchAll(parent::FETCH_NUM);

      foreach ($results as $row) {

        $result[$row[0]] = $row[1];
      }
    }

    return $result;
  }

  /**
   * Get an specific record as a row.
   *
   * <code>
   *   // Get all fields of the note with id = 1 (using value)
   *   Database::getRow('SELECT * FROM notes WHERE id = ?', [1]);
   *
   *   // Get all fields of the note with id = 1 (using binded param)
   *   Database::getRow('SELECT * FROM notes WHERE id = :id', ['id' => 1]);
   * </code>
   *
   * @param string $sql_query SQL statement to be prepared an executed.
   * @param array $params SQL statement arguments.
   * @param string $class_name Optional class name to fetch the results.
   * @return mixed Specified record fields.
   */
  public function getRow (string $sql_query, array $params = [], string $class_name = '') : mixed {

    $result = null;

    if ($this->_query($sql_query, $params, $class_name)) {

      $result = $this->statement->fetch();
    }

    return $result;
  }

  /**
   * Get records field values as a column.
   *
   * <code>
   *   // Get all notes text field values
   *   Database::column('SELECT text FROM notes');
   *
   *   // Get all notes text with priority = 1 (using value)
   *   Database::getColumn
   *   (
   *     'SELECT text FROM notes WHERE priority = ?',
   *     [1]
   *   );
   *
   *   // Get all notes with priority = 1 (using binded param)
   *   Database::getColumn
   *   (
   *     'SELECT text FROM notes WHERE priority = :priority',
   *     ['priority' => 1]
   *   );
   * </code>
   *
   * @param string $sql_query SQL statement to be prepared an executed.
   * @param array $params SQL statement arguments.
   * @return array Values of the specified record field.
   */
  public function getColumn (string $sql_query, array $params = []) : array {

    $result = null;

    if ($this->_query($sql_query, $params)) {

      $result = $this->statement->fetchAll(parent::FETCH_COLUMN);
    }

    return $result;
  }

  /**
   * Retrieve the results of an SQL statement.
   *
   * <code>
   *   // Get all notes from database
   *   Database::getResults('SELECT * FROM notes');
   *
   *   // Get all notes with priority = 1 (using value)
   *   Database::getResults
   *   (
   *     'SELECT * FROM notes WHERE priority = ?',
   *     [1]
   *   );
   *
   *   // Get all notes with priority = 1 (using binded param)
   *   Database::getResults
   *   (
   *     'SELECT * FROM notes WHERE priority = :priority',
   *     ['priority' => 1]
   *   );
   * </code>
   *
   * @param string $sql_query SQL statement to be prepared an executed.
   * @param array $params SQL statement arguments.
   * @param string $class_name Optional class name to fetch the results.
   * @return array Specified records fields.
   */
  public function getResults (string $sql_query, array $params = [], string $class_name = '') : array {

    $result = null;

    if ($this->_query($sql_query, $params, $class_name)) {

      $result = $this->statement->fetchAll();
    }

    return $result;
  }

  /**
   * Find if certain database record exists.
   *
   * <code>
   *   // Find if a note with id = 1 exists
   *   if (Database::exists('notes', ['id' => 1])) {
   *     // Make something
   *   }
   *
   *   // Find if a note with id = 1 and priority = 1 exists
   *   if (Database::exists('notes', ['id' => 1, 'priority' => 1])) {
   *     // Make something
   *   }
   * </code>
   *
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True if the record exists, False if not.
   */
  public function exists (string $table_name, array $key_values) : bool {

    $params = [];
    $pre_keys = StrUtils::EMPTY_STRING;

    foreach ($key_values as $field => $value) {

      $pre_keys .= " AND ({$field}) = ? ";

      $params[] = $value;
    }

    return $this->getValue(
      \sprintf('SELECT 1 as c FROM %s WHERE (1 = 1) %s',
       $table_name, $pre_keys), $params) !== null;
  }

  /**
   * Insert a new database record.
   *
   * <code>
   *   # Insert a new note
   *   Database::insert
   *   (
   *     'notes',
   *     ['text' => 'First note', 'date' => time()]
   *   );
   * </code>
   *
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True on succes, False on failure.
   */
  public function insert (string $table_name, array $key_values) : bool {

    $params = [];
    $pre_sql_values = StrUtils::EMPTY_STRING;
    $pre_sql_fields = StrUtils::EMPTY_STRING;

    foreach ($key_values as $field => $value) {

      $pre_sql_values .= '?,';
      $pre_sql_fields .= $field . ',';

      $params[] = $value;
    }

    $sql_query_values = \trim($pre_sql_values, ',');
    $sql_query_fields = \trim($pre_sql_fields, ',');

    $result = $this->_query("INSERT INTO {$table_name} ({$sql_query_fields}) VALUES ({$sql_query_values})", $params);

    return $result instanceof \PDOStatement;
  }

  /**
   * Update an existing database record.
   *
   * <code>
   *   # Update note text and title with ID = 1
   *   Database::update
   *   (
   *     'notes',
   *     ['id' => 1],
   *     ['text' => 'New text', 'title' => 'New title']
   *   );
   * </code>
   *
   * @param string $table_name Database table name.
   * @param array $key_fields Associated array with field keys.
   * @param array $field_values Associated array with field values.
   * @return bool True on succes, False on failure.
   */
  public function update (string $table_name, array $key_fields, array $field_values) : bool {

    $result = false;

    if ($this->exists($table_name, $key_fields)) {

      $params = [];
      $preKeys = StrUtils::EMPTY_STRING;
      $pre_sql_values = StrUtils::EMPTY_STRING;

      foreach ($field_values as $field => $value) {

        $pre_sql_values .= " {$field} = ?,";

        $params[] = $value;
      }

      foreach ($key_fields as $field => $value) {

        $preKeys .= " AND ({$field} = ?)";

        $params[] = $value;
      }

      $sql_query_keys = $preKeys;
      $sql_query_values = \trim($pre_sql_values, ',');

      $results = $this->_query(
        \sprintf('UPDATE %s SET %s WHERE (1 = 1) %s',
         $table_name, $sql_query_values, $sql_query_keys),
         $params);

      $result = $results instanceof \PDOStatement;
    }

    return $result;
  }

  /**
   * Delete a record from the database.
   *
   * <code>
   *  <?php
   *   // Delete the note with ID = 1
   *   Database::delete('notes', ['id' => 1]);
   *
   *   // Delete the note with ID = 1 and priority = 1
   *   Database::delete('notes', ['id' => 1, 'priority' => 1]);
   *  ?>
   * </code>
   *
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True on succes, False on failure.
   */
  public function delete (string $table_name, array $key_values) :bool {

    $params = [];
    $sql_query_keys = StrUtils::EMPTY_STRING;

    foreach ($key_values as $field => $value) {

      $sql_query_keys .= " AND ({$field} = ?)";

      $params[] = $value;
    }

    $result = $this->_query(
      \sprintf('DELETE FROM %s WHERE (1 = 1) %s', $table_name, $sql_query_keys), $params);

    return $result instanceof \PDOStatement;
  }

  /**
   * Get the affected last SQL statement affedted rows.
   *
   * @return int Affected rows by the last SQL statement.
   */
  public function getRowCount () : int {

    return $this->statement->getRowCount();
  }

  /**
   * Get the currently used database fetch mode.
   *
   * @return int Fetch mode currently used.
   */
  public function getFetchMode () : int {

    return $this->fetch_mode;
  }

  /**
   * Set the specified database fecth mode.
   *
   * @param int $fetch_mode Database fetch mode.
   */
  public function setFetchMode (int $fetch_mode) : void {

    if ($this->fetch_mode !== $fetch_mode) {
      $this->fetch_mode = $fetch_mode;
    }
  }

  /**
   * Retrieve the currently used database fetch class.
   *
   * @return string Fetch class name
   */
  public function getFetchClass () : string {

    return $this->fetch_class;
  }

  /**
   * Set the fetch class which you want to use.
   *
   * @param string $class_name Class name
   */
  public function setFetchClass (string $class_name) : void {

    if ($this->fetch_class !== $class_name) {

      $this->fetch_class = $class_name;
      $this->fetch_mode = parent::FETCH_CLASS;
    }
  }

  /**
   * Retrieve the currently used database driver name.
   *
   * @return mixed Database driver name attribute.
   */
  public function getDriverName () : mixed {

    return $this->getAttribute(parent::ATTR_DRIVER_NAME);
  }

  /**
   * Get the established database error mode.
   *
   * @return mixed Database error mode attribute.
   */
  public function getErrorMode () : mixed {

    return $this->getAttribute(parent::ATTR_ERRMODE);
  }

  /**
   * Set the database error mode to use.
   *
   * @param int $error_mode Error mode to be established.
   * @return bool True on success, False on failure
   */
  public function setErrorMode ($error_mode) : bool {

    return $this->setAttribute(parent::ATTR_ERRMODE, $error_mode);
  }

  /**
   * Execute an SQL statement and return the number of affected rows.
   *
   * @link http://www.php.net/manual/en/pdo.exec.php
   * @param string $sql_query The SQL statement to prepare and execute.
   * @return int Number of affected rows or zero if not affected.
   */
  public function exec ($sql_query) : int {

    return parent::exec($this->translateSQL($sql_query));
  }

  /**
   * Prepares a statement for execution and returns a statement object.
   *
   * @link http://www.php.net/manual/en/pdo.prepare.php
   * @param string $sql_query The SQL statement to prepare.
   * @param array $options Driver specific options.
   * @return \PDOStatement|false object instance or false.
   */
  public function prepare (string $sql_query, array $options = []) : \PDOStatement|false {

    return parent::prepare($this->translateSQL($sql_query), $options);
  }

  /**
   * Closes the cursor, enabling the statement to be executed again.
   *
   * @link https://www.php.net/manual/en/pdostatement.closecursor
   * @return bool True on success, False on failure
   */
  public function closeCursor () : bool {

    if ($this->statement instanceof \PDOStatement) {
      return $this->statement->closeCursor();
    }

    return true;
  }

  /**
   * Executes an SQL statement, returning a result set.
   *
   * @link http://www.php.net/manual/en/pdo.query.php
   * @param string $sql_query The SQL statement to prepare and execute.
   * @param array $params The SQL statement arguments.
   * @param string $class_name Class name to fetch the results.
   * @return \PDOStatement|false object instance or False on failure.
   */
  public function _query (string $sql_query, array $params = [], string $class_name = '') : \PDOStatement|false {

    $result = false;

    if ($this->statement instanceof \PDOStatement) {
      $this->statement->closeCursor();
    }

    $this->statement = $this->prepare
    (
      $this->translateSQL($sql_query, $params),
      [self::ATTR_EMULATE_PREPARES => true]
    );

    if ($this->statement instanceof \PDOStatement) {

      if (!StrUtils::isTrimEmpty($class_name)) {
        $this->fetch_class = $class_name;
        $this->fetch_mode = parent::FETCH_CLASS;
      }

      if ($this->fetch_mode === parent::FETCH_CLASS) {
        $this->statement->setFetchMode(parent::FETCH_CLASS, $this->fetch_class);
      } else {
        $this->statement->setFetchMode($this->fetch_mode);
      }

      if ($this->statement->execute($params)) {
        // Back to the default class
        $this->fetch_class = self::DEFAULT_FETCH_CLASS;
        $result = $this->statement;
      }
    }

    return $result;
  }

  /**
   * Translate an SQL statement for an specific driver.
   *
   * Since Humm use PHP PDO and therefore support various
   * database drivers, this method is intended to offer a
   * way to the user (using a plugin) in order to translate
   * SQL queries into specific database drivers queries.
   *
   * @param string $sql_query The SQL statement to prepare and execute.
   * @param array $params The SQL statement arguments.
   * @return string Untouched or translated SQL statement
   */
  private function translateSQL(string $sql_query, array $params = []) : string {

    return HummPlugins::applyFilter(new FilterArguments([
      FilterArguments::CONTENT => $sql_query,
      FilterArguments::BUNDLE => $params,
      FilterArguments::FILTER => PluginFilters::DATABASE_SQL
    ]));
  }
}
