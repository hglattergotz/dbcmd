Generic API for running console commands against a DB (previously hgg/dbbackup)
from within a PHP application.

Warning: The commands are constructed containing the password in order to run non-interactive. This can be considered to be insecure.

Operations include:

 * Create a database
 * Drop a database
 * Dump a table to a dump file
 * Dump a database to a dump file
 * Load a table from a dump file

[![Build Status](https://travis-ci.org/hglattergotz/dbcmd.svg)](https://travis-ci.org/hglattergotz/dbcmd)

## Installation

Using Composer:

```json
{
    "require": {
        "hgg/dbcmd": "dev-master"
    }
}
```

Download source and manually add to project:

 - Get the zip file [here](http://github.com/hglattergotz/dbcmd/archive/master.zip)

## Supported Databases:

 - MySql

Pull Requests for additional database engines welcome!

## Usage

### Dump entire database

```php
use HGG\DbCmd\CmdBuilder\MySql;
use HGG\DbCmd\DbCmd;

try
{
    $output = '';
    $cmd = new DbCmd(new MySql());
    $cmd->dumpDatabase('username', 'password', 'localhost', 'database',
        'dumpFile', array(), &$output);
    
    // log $output
}
catch (\Exception $e)
{
    // deal with failure
}
```

### Dump specific tables in a database

```php
use HGG\DbCmd\CmdBuilder\MySql;
use HGG\DbCmd\DbCmd;

try
{
    $output = '';
    $cmd = new DbCmd(new MySql());
    $cmd->dumpTables('username', 'password', 'localhost', 'database',
        array('table1', 'table2'), 'dumpFile', array(), &$output);
    
    // log $output
}
catch (\Exception $e)
{
    // deal with failure
}
```

### Restore form a dump file

```php
use HGG\DbCmd\CmdBuilder\MySql;
use HGG\DbCmd\DbCmd;

try
{
    $output = '';
    $cmd = new DbCmd(new MySql());
    $cmd->load('username', 'password', 'localhost', 'database',
        'dumpFile', array(), &$output);
    
    // log $output
}
catch (\Exception $e)
{
    // deal with failure
}
```
