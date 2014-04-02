<?php

/**
 * This file is part of the HGG package.
 *
 * (c) 2014 Henning Glatter-Götz <henning@glatter-gotz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGG\DbCmd;

use Symfony\Component\Process\Process;

/**
 * DbCmd
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class DbCmd
{
    /**
     * cmdBuilder
     *
     * @var mixed
     * @access protected
     */
    protected $cmdBuilder;

    /**
     * timeout
     *
     * @var mixed
     * @access protected
     */
    protected $timeout;

    /**
     * __construct
     *
     * @param mixed $cmdBuilder
     * @param int   $timeout
     *
     * @access public
     * @return void
     */
    public function __construct($cmdBuilder, $timeout = 3600)
    {
        $this->cmdBuilder = $cmdBuilder;
        $this->timeout    = $timeout;
    }

    /**
     * dumpDatabase
     *
     * Backup an entire database to a file
     *
     * @param string $username   The username for database access
     * @param string $password   The password for database access
     * @param string $host       The host
     * @param string $database   The name of the database
     * @param string $backupFile The target file
     * @param array  $options    Any options to be passed on to the cmd builder
     * @param mixed  &$output    The output from the process
     *
     * @access public
     * @throws \Exception
     * @return boolean
     */
    public function dumpDatabase($username, $password, $host, $database, $backupFile, array $options, &$output)
    {
        return $this->dumpTables($username, $password, $host, $database, array(), $backupFile, $options, $output);
    }

    /**
     * dumpTables
     *
     * Dump specific tables in a database to a file
     *
     * @param mixed  $username   The username for database access
     * @param mixed  $password   The password for database access
     * @param string $host       The host
     * @param mixed  $database   The name of the database
     * @param array  $tables     The list of tables
     * @param mixed  $backupFile The target file
     * @param array  $options    Any options to be passed on to the cmd builder
     * @param mixed  &$output    The output from the process
     *
     * @access public
     * @throws \Exception
     * @return boolean
     */
    public function dumpTables($username, $password, $host, $database, array $tables, $backupFile, array $options, &$output)
    {
        $cmd = $this->cmdBuilder->dump($username, $password, $host, $database, $tables, $backupFile, $options);

        return $this->run($cmd, $output);
    }

    /**
     * Load a dump file
     *
     * @param mixed $username
     * @param mixed $password
     * @param mixed $host
     * @param mixed $database
     * @param mixed $backupFile
     * @param array $options
     * @param mixed &$output
     *
     * @access public
     * @return void
     */
    public function load($username, $password, $host, $database, $backupFile, array $options, &$output)
    {
        $cmd = $this->cmdBuilder->load($username, $password, $host, $database, $backupFile, $options);

        return $this->run($cmd, $output);
    }

    /**
     * Run the console command
     *
     * @param mixed $cmd
     * @param mixed &$output
     *
     * @access protected
     * @return void
     */
    protected function run($cmd, &$output)
    {
        $proc = new Process($cmd, null, null, null, $this->timeout);
        $proc->run();

        if (!$proc->isSuccessful()) {
            throw new \Exception($proc->getErrorOutput());
        }

        $output = $proc->getOutput();

        return true;
    }
}
