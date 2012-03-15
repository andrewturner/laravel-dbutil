# DBUtil for LaravelPHP #

When working w/ the DB class I found I couldn't do some simple DB management functions.  Something to do w/ how the DB class interacts w/ the PDO connection.  I made this class to handle the handful of misc management functions I needed.

* ``DBUtil::truncate($table);`` Runs simple truncate on table.
* ``DBUtil::optimize($table);`` Runs simple optimize on table.
* ``DBUtil::columns($table);`` Returns array of available columns for table.
* ``DBUtil::tables();`` Returns array of available tables for connection.
* ``DBUtil::databases();`` Returns array of available databases.