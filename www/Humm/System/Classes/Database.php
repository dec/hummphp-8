<?php

/**
 * This file implement the Database system class.
 *
 * Humm PHP use this class to provide user site classes,
 * views and plugins with an easy way to work with databases.
 *
 * @author DecSoft Utils <info@decsoftutils.com>
 * @link https://www.decsoftutils.com/
 * @license https://www.gnu.org/licenses/gpl.html
 * @copyright (C) Humm PHP - DecSoft Utils
 */

namespace Humm\System\Classes;

/**
 * System Database class implementation.
 *
 * This class can be used by user site classes, views
 * and plugins to connect and work with databases.
 */
class Database extends Unclonable {

  /**
   * Store our PDOExtended object.
   *
   * @var PDOExtended
   */
  private static ?PDOExtended $pdo = null;

  /**
   * Look for the database DSN and try to connect if exists.
   *
   * An user site can set the HUMM_DATABASE_DSN constant
   * with the appropiate database DSN string in order to
   * perform an automatically database connection.
   *
   * @static
   * @staticvar int $init Prevent twice execution.
   */
  public static function init () : void {

    static $init = 0;

    if (!$init) {

      $init = 1;

      if (!StrUtils::isTrimEmpty(\HUMM_DATABASE_DSN)) {

        self::tryToConnect();
      }
    }
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
   * @static
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True if the record exists, False if not.
   */
  public static function exists (string $table_name, array $key_values) : bool {

    return self::$pdo->exists($table_name, $key_values);
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
   * @static
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True on succes, False on failure.
   */
  public static function delete (string $table_name, array $key_values) : bool {

    return self::$pdo->delete($table_name, $key_values);
  }

  /**
   * Insert a new database record.
   *
   * <code>
   *   # Insert a new note
   *   Database::insert
   *   (
   *     'notes',
   *     [
   *       'text' => 'First note',
   *       'date' => time()
   *     ]
   *   );
   * </code>
   *
   * @static
   * @param string $table_name Database table name.
   * @param array $key_values Associated array with field keys/values.
   * @return bool True on succes, False on failure.
   */
  public static function insert (string $table_name, array $key_values) : bool {

    return self::$pdo->insert($table_name, $key_values);
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
   * @static
   * @param string $table_name Database table name.
   * @param array $key_fields Associated array with field keys.
   * @param array $field_values Associated array with field values.
   * @return bool True on succes, False on failure.
   */
  public static function update (string $table_name, array $key_fields, array $field_values) : bool {

    return self::$pdo->update($table_name, $key_fields, $field_values);
  }

  /**
   * Get record fields as key and value pairs.
   *
   * <code>
   *   // Get date (as key) and text (as value) note with id = 1
   *   Database::keyVal
   *   (
   *     'SELECT date, text FROM notes WHERE id = ?', [1]
   *   );
   *
   *   // Get date (as key) and text (as value) note with id = 1
   *   Database::keyVal
   *   (
   *     'SELECT date, text FROM notes WHERE id = :id', ['id' => 1]
   *   );
   * </code>
   *
   * @static
   * @param string $sql_query SQL statement to be prepared and executed.
   * @param array $params SQL statement parameters.
   * @return array Record field keys and values pairs.
   */
  public static function getPair (string $sql_query, array $params = []) : array {

    return self::$pdo->getPair($sql_query, $params);
  }

  /**
   * Get an specific record field value.
   *
   * <code>
   *   // Get the text of a note with id = 1 (using value)
   *   Database::val
   *   (
   *     'SELECT text FROM notes WHERE id = ?',
   *     [1]
   *   );
   *
   *   // Get the text of a note with id = 1 (using binded param)
   *   Database::val
   *   (
   *     'SELECT text FROM notes WHERE id = :id',
   *     ['id' => 1]
   *   );
   * </code>
   *
   * @static
   * @param string $sql_query SQL statement to be prepared and executed.
   * @param array $params SQL statement arguments.
   * @return ?string Value of the specified record field or null if not found.
   */
  public static function getValue (string $sql_query, array $params = []) : ?string {

    return self::$pdo->getValue($sql_query, $params);
  }

  /**
   * Get records field values as a column.
   *
   * <code>
   *   // Get all notes text field values
   *   Database::column('SELECT text FROM notes');
   *
   *   // Get all notes text with priority = 1 (using value)
   *   Database::column
   *   (
   *     'SELECT text FROM notes WHERE priority = ?',
   *     [1]
   *   );
   *
   *   // Get all notes with priority = 1 (using binded param)
   *   Database::column
   *   (
   *     'SELECT text FROM notes WHERE priority = :priority',
   *     ['priority' => 1]
   *   );
   * </code>
   *
   * @static
   * @param string $sql_query SQL statement to be prepared an executed.
   * @param array $params SQL statement arguments.
   * @return array Values of the specified record field.
   */
  public static function getColumn (string $sql_query, array $params = []) : array {

    return self::$pdo->getColumn($sql_query, $params);
  }

  /**
   * Get an specific record as a row.
   *
   * <code>
   *   // Get all fields of the note with id = 1 (using value)
   *   Database::row('SELECT * FROM notes WHERE id = ?', [1]);
   *
   *   // Get all fields of the note with id = 1 (using binded param)
   *   Database::row('SELECT * FROM notes WHERE id = :id', ['id' => 1]);
   * </code>
   *
   * @static
   * @param string $sql_query SQL statement to be prepared an executed.
   * @param array $params SQL statement arguments.
   * @param string $class_name Optional class name to fetch the results.
   * @return array|object|null Specified record fields.
   */
  public static function getRow (string $sql_query, array $params = [], string $class_name = '') : array|object|null {

    return self::$pdo->getRow($sql_query, $params, $class_name);
  }

  /**
   * Retrieve the results of an SQL statement.
   *
   * <code>
   *   // Get all notes from database
   *   Database::results('SELECT * FROM notes');
   *
   *   // Get all notes with priority = 1 (using value)
   *   Database::results
   *   (
   *     'SELECT * FROM notes WHERE priority = ?',
   *     [1]
   *   );
   *
   *   // Get all notes with priority = 1 (using binded param)
   *   Database::results
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
  public static function getResults (string $sql_query, array $params = [], string $class_name = '') : array {

    return self::$pdo->getResults($sql_query, $params, $class_name);
  }

  /**
   * Get the affected last SQL statement affedted rows.
   *
   * @static
   * @return int Affected rows by the last SQL statement.
   */
  public static function getRowCount () : int {

    return self::$pdo->getRowCount();
  }

  /**
   * Get the currently used database fetch mode.
   *
   * @static
   * @return int Fetch mode currently used.
   */
  public static function getFetchMode () : int {

    return self::$pdo->getFetchMode();
  }

  /**
   * Set the specified database fecth mode.
   *
   * @static
   * @param int $fetch_mode Database fetch mode.
   */
  public static function setFetchMode (int $fetch_mode) : void {

    self::$pdo->setFetchMode($fetch_mode);
  }

  /**
   * Retrieve the currently used database fetch class.
   *
   * @static
   * @return string Fetch class name
   */
  public static function getFetchClass () : string {

    return self::$pdo->getFetchClass();
  }

  /**
   * Set the fetch class which you want to use.
   *
   * @static
   * @param string $class_name Class name.
   */
  public static function setFetchClass (string $class_name) : void {

    self::$pdo->setFetchClass($class_name);
  }

  /**
   * Retrieve the currently used database driver name.
   *
   * @static
   * @return mixed Database driver name attribute.
   */
  public static function getDriverName () : mixed {

    return self::$pdo->getDriverName();
  }

  /**
   * Get the established database error mode.
   *
   * @static
   * @return mixed Database error mode attribute.
   */
  public static function getErrorMode () : mixed {

    return self::$pdo->getErrorMode();
  }

  /**
   * Set the database error mode to use.
   *
   * @static
   * @param int $error_mode Error mode to be established.
   * @return bool True on success, False on failure
   */
  public static function setErrorMode (int $error_mode) : bool {

    return self::$pdo->setErrorMode($error_mode);
  }

  /**
   * Perform a connection with a database.
   *
   * @static
   * @param string $dsn Database connection string.
   * @param string $user Database user name.
   * @param string $pass Database user password.
   * @param array $options Database connection options.
   * @param boolean $force True to force a connection, False to not.
   * @return bool True on success connection, False if fail.
   */
  public static function connect (string $dsn, string $user = '',
   string $pass = '', array $options = [], bool $force = false) : bool {

    $result = false;

    if (!(self::$pdo instanceof \PDO) || $force) {

      self::$pdo = new PDOExtended($dsn, $user, $pass, $options);

      $result = self::$pdo instanceof \PDO;
    }

    return $result;
  }

  /**
   * Disconnect from the database.
   *
   * @static
   */
  public static function disconnect () : void {

    if (self::$pdo instanceof \PDO) {

      self::$pdo = null;
    }
  }

  /**
   * Find if the database connectino is established.
   *
   * @static
   * @return bool True if is connected, False when not
   */
  public static function isConnected () : bool {

    return self::$pdo instanceof \PDO;
  }

  /**
   * Retrieve the last operation error information.
   *
   * @static
   * @link http://php.net/manual/en/pdo.errorinfo.php
   * @return array Last error information.
   */
  public static function errorInfo () : array {

    return self::$pdo->errorInfo();
  }

  /**
   * Retrieve the last error operation message.
   *
   * @static
   * @link http://php.net/manual/en/pdo.errorinfo.php
   * @return ?string Last error message or null.
   */
  public static function errorMessage () : ?string {

    $error_info = self::$pdo->errorInfo();

    return isset($error_info[2]) ? $error_info[2] : null;
  }

  /**
   * Retrieve the last operation error code.
   *
   * @static
   * @link http://php.net/manual/en/pdo.errorcode.php
   * @return ?string Last error message.
   */
  public static function errorCode () : ?string {

    return self::$pdo->errorCode();
  }

  /**
   * Initiates a transaction
   *
   * @static
   * @link www.php.net/manual/en/pdo.begintransaction.php
   * @return bool True on success or False on failure.
   */
  public static function beginTransaction () : bool {

    return self::$pdo->beginTransaction();
  }

  /**
   * Checks if inside a transaction.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.intransaction.php
   * @return bool True if a trasantion is active, False if not
   */
  public static function inTransaction () : bool {

    return self::$pdo->inTransaction();
  }

  /**
   * Commits a transaction.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.commit.php
   * @return bool True on success, False on failure
   */
  public static function commit () : bool {

    return self::$pdo->commit();
  }

  /**
   * Rolls back a transaction.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.rollback.php
   * @return bool True on success, False on failure
   */
  public static function rollBack () : bool {

    return self::$pdo->rollBack();
  }

  /**
   * Quotes a string for use in a query.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.quote.php
   * @param string $unsafe_string Unsafe string to be quoted.
   * @param int $param_type Hint for drivers that have alternate quoting styles.
   * @return string|false Safe quoted string or False if an error occur.
   */
  public static function quote (string $unsafe_string, int $param_type = \Pdo::PARAM_STR) : string|false {

    return self::$pdo->quote($unsafe_string, $param_type);
  }

  /**
   * Retrieve the ID of the last inserted row or sequence value.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.lastinsertid.php
   * @param string $sequence_name Optional Name of the sequence object.
   * @return string|false Last inserted row ID or false.
   */
  public static function lastInsertID (string $sequence_name = '') : string|false {

    return self::$pdo->lastInsertID($sequence_name);
  }

  /**
   * Retrieve a database connection attribute.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.getattribute.php
   * @param int $attribute One of the PDO::ATTR_* constants.
   * @return mixed Value of the requested PDO attribute or null.
   */
  public static function getAttribute (int $attribute) : mixed {

    return self::$pdo->getAttribute($attribute);
  }

  /**
   * Set a database connection attribute.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.setattribute.php
   * @param int $attribute One of the PDO::ATTR_* constants.
   * @param mixed $value Connection attribute value.
   * @return bool True on success, False on failure.
   */
  public static function setAttribute (int $attribute, mixed $value) : bool {

    return self::$pdo->setAttribute($attribute, $value);
  }

  /**
   * Execute an SQL statement and return the number of affected rows.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.exec.php
   * @param string $sql_query The SQL statement to prepare and execute.
   * @return int Number of affected rows or zero if not affected.
   */
  public static function exec(string $sql_query) : int {

    return self::$pdo->exec($sql_query);
  }

  /**
   * Prepares a statement for execution and returns a statement object.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.prepare.php
   * @param string $sql_query The SQL statement to prepare.
   * @param array $options Driver specific options.
   * @return \PDOStatement|false object instance or false.
   */
  public static function prepare (string $sql_query, array $options = []) : \PDOStatement|false {

    return self::$pdo->prepare($sql_query, $options);
  }

  /**
   * Closes the cursor, enabling the statement to be executed again.
   *
   * @static
   * @link https://www.php.net/manual/en/pdostatement.closecursor
   * @return bool True on success, False on failure
   */
  public static function closeCursor () : bool {

    return self::$pdo->closeCursor();
  }

  /**
   * Executes an SQL statement, returning a result set.
   *
   * @static
   * @link http://www.php.net/manual/en/pdo.query.php
   * @param string $sql_query The SQL statement to prepare and execute.
   * @param array $params The SQL statement arguments.
   * @param string $class_name Class name to fetch the results.
   * @return \PDOStatement|false object instance or False on failure.
   */
  public function query (string $sql_query, array $params = [], string $class_name = '') : \PDOStatement|false {

    return self::$pdo->_query($sql_query, $params, $class_name);
  }

  /**
   * Try a database connectin and notify the plugins if success.
   *
   * @static
   */
  private static function tryToConnect () : void {

    if (self::connect(\HUMM_DATABASE_DSN, \HUMM_DATABASE_USER, \HUMM_DATABASE_PASS)) {

       HummPlugins::execSimpleAction(PluginActions::DATABASE_CONNECTED);
    }
  }
}
