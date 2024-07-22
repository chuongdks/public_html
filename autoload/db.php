<?php

abstract class db
{
  private static $dbh = NULL;

  public function __construct($enable_exceptions=TRUE)
  {
    global $CFG;

    // If Database Handle is NULL 
    if (self::$dbh === NULL)
    {
      // This string is a DSN URL type string for Database system
      $dsn = $CFG->dbtype.':host='.$CFG->dbhost.';dbname='.$CFG->dbname;
      
      // Seach PDO (PHP Data Objects)
      self::$dbh = new PDO($dsn, $CFG->dbuser, $CFG->dbpass);

      // If content in DBH is not NULL, set up stuff (Like fopen in C)
      if (self::$dbh !== NULL)
      {
        // Turn on or off Exception by enabling $enable_exceptions
        if ($enable_exceptions === TRUE)
          self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        else
          self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

        self::$dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        self::$dbh->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
      }
    }
  }

  protected final function db_handle()
  {
    return self::$dbh;
  }

  protected final function admin_permit_create_drop()
  {
    global $CFG;

    return
        $CFG->db_admin_permit_create_drop === TRUE &&
        $CFG->db_admin_only_allow_ip == http_utils::get_client_ip_address()
    ;
  }

  public abstract function admin_create_db();
  public abstract function admin_destroy_db();
}

?>
