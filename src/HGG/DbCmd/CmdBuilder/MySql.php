<?php

/**
 * This file is part of the HGG package.
 *
 * (c) 2013 Henning Glatter-Götz <henning@glatter-gotz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGG\DbCmd\CmdBuilder;

use HGG\DbCmd\CmdBuilder\CmdBuilder;

/**
 * Command line construction utility for creating MySQL specific commands using
 * mysqldump and mysqladmin.
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class MySql implements CmdBuilder
{
    /**
     * Creates a database create command
     *
     * @param mixed $username
     * @param mixed $password
     * @param mixed $host
     * @param mixed $database
     *
     * @access public
     * @return void
     */
    public function createDatabase($username, $password, $host, $database)
    {
        $components = array('mysql');

        $components[] = '-u '.escapeshellarg($username);
        $components[] = '-p'.escapeshellarg($password);
        $components[] = '-h '.escapeshellarg($host);
        $components[] = '-e '.escapeshellarg('CREATE DATABASE '.$database);

        return implode(' ', $components);
    }

    /**
     * Creates a database drop command
     *
     * @param mixed $username
     * @param mixed $password
     * @param mixed $host
     * @param mixed $database
     *
     * @access public
     * @return void
     */
    public function dropDatabase($username, $password, $host, $database)
    {
        $components = array('mysql');

        $components[] = '-u '.escapeshellarg($username);
        $components[] = '-p'.escapeshellarg($password);
        $components[] = '-h '.escapeshellarg($host);
        $components[] = '-e '.escapeshellarg('DROP DATABASE IF EXISTS '.$database);

        return implode(' ', $components);
    }

    /**
     * Creates a MySQL dump command
     *
     * @param string $username
     * @param string $password
     * @param string $host
     * @param string $database
     * @param array $tables
     * @param string $backupFile
     * @param array $options
     *
     * @access protected
     * @return void
     */
    public function dump($username, $password, $host, $database, array $tables, $backupFile, array $options)
    {
        $components = array('mysqldump');

        $components[] = '-u '.escapeshellarg($username);
        $components[] = '-p'.escapeshellarg($password);
        $components[] = '-h'.escapeshellarg($host);
        $components = array_merge($components, $options);
        $components[] = escapeshellarg($database);
        $components = array_merge($components, array_map('escapeshellarg', $tables));
        $components[] = '> '.escapeshellarg($backupFile);

        return implode(' ', $components);
    }

    /**
     * Creates a MySQL load command
     *
     * @param mixed $username
     * @param mixed $password
     * @param mixed $host
     * @param mixed $database
     * @param mixed $backupFile
     * @param array $options
     *
     * @access public
     * @return void
     */
    public function load($username, $password, $host, $database, $backupFile, array $options)
    {
        $components = array('mysql');

        $components[] = '-u '.escapeshellarg($username);
        $components[] = '-p'.escapeshellarg($password);
        $components[] = '-h'.escapeshellarg($host);
        $components = array_merge($components, $options);
        $components[] = escapeshellarg($database);
        $components[] = '< '.escapeshellarg($backupFile);

        return implode(' ', $components);
    }
}

