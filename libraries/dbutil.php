<?php

/**
 * A LaravelPHP Package for DB management functions.
 *
 * @package    DBUtil
 * @author     Scott Travis <scott.w.travis@gmail.com>
 * @link       http://github.com/swt83/laravel-dbutil
 * @license    MIT License
 */

class DBUtil {

    /**
     * Make a table.
     *
     * @param   string  $table
     * @param   array   $columns
     * @return  void
     */
    public static function make($table, $columns, $connection = null)
    {
        // load existing tables
        $existing = static::tables();
        
        // check if already exists...
        if (in_array($table, $existing))
        {
            // error
            trigger_error('Table already exists.');

            // return
            return false;
        }

        // Laravel provides a mechanism for building tables,
        // but only in the context of migrations which are run
        // at the command line.  The following is a makeshift
        // way of achieving the same thing using the same methods.
        
        // NOTE: I don't know how to make this work w/ a custom
        // connection.  Only working w/ default connection.

        $db = new Laravel\Database\Schema\Table($table);
        $db->create();
        $db->increments('id');

        // for each column...
        foreach ($columns as $name => $value)
        {
            // The makeup of the $columns array is to define
            // each field w/ the name as the key, and the
            // value containing both a type and a length.

            $type = $value['type'];
            $length = $value['length'];

            // add to schema
            $db->$type($name, $length);
        }

        // execute
        Schema::execute($db);
    }

    /**
     * Drop a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function drop($table, $connection = null)
    {
        DB::connection($connection)->pdo->query('drop '.$table);
    }

    /**
     * Truncate a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function truncate($table, $connection = null)
    {
        DB::connection($connection)->pdo->query('truncate '.$table);
    }
    
    /**
     * Optimize a table.
     *
     * @param   string  $table
     * @return  void
     */
    public static function optimize($table, $connection = null)
    {
        DB::connection($connection)->pdo->query('optimize table '.$table);
    }
    
    /**
     * Get array of tables columns.
     *
     * @param   string  $table
     * @param   string  $connection
     * @return  array
     */
    public static function columns($table, $connection = null)
    {
        // query the pdo
        $result = DB::connection($connection)->pdo->query('show columns from '.$table);
        
        // build array
        $columns = array();
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
            $columns[] = $row[0];
        }
        
        // return
        return $columns;
    }
    
    /**
     * Get array of database tables.
     *
     * @param   string  $connection
     * @return  array
     */
    public static function tables($connection = null)
    {
        // capture pdo
        $pdo = DB::connection($connection)->pdo;
    
        // run query
        $result = $pdo->query('show tables');
        
        // build array
        $tables = array();
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
            $tables[] = $row[0];
        }
        
        // return
        return $tables;
    }
    
    /**
     * Get array of databases.
     *
     * @param   string  $connection
     * @return  array
     */
    public static function databases($connection = null)
    {
        // query the pdo
        $result = DB::connection($connection)->pdo->query('show databases');
        
        // build array
        $db = array();
        while ($row = $result->fetch(PDO::FETCH_NUM))
        {
            $db[] = $row[0];
        }
        
        // return
        return $db;
    }

}