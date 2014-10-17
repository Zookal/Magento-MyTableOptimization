<?php

/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this Module to
 * newer versions in the future.
 *
 * @category    Zookal_TableOpt
 * @package     Model
 * @author      Cyrill Schumacher | {firstName}@{lastName}.fm | @SchumacherFM
 * @copyright   Copyright (c) Zookal Pty Ltd
 * @license     OSL - Open Software Licence 3.0 | http://opensource.org/licenses/osl-3.0.php
 */
class Zookal_TableOpt_Model_Optimize extends Varien_Object
{
    /**
     * @var Zookal_TableOpt_Helper_Data
     */
    protected $_helper;

    /**
     * @var array
     */
    protected $_tableStatuses = array();

    /**
     * @param Magento_Db_Adapter_Pdo_Mysql $connection
     * @param Zookal_TableOpt_Helper_Data  $helper
     */
    public function __construct($connection = null, $helper = null)
    {
        if (false === empty($connection)) {
            $this->_connection = $connection;
        }
        if (false === empty($helper)) {
            $this->_helper = $helper;
        }
        $this->_initTableStatuses();
    }

    /**
     * @return array|false
     */
    public function run()
    {
        if (true !== $this->getHelper()->isActive()) {
            return false;
        }

        $isCli         = $this->hasCli();
        $tables        = $this->getTables();
        $engines       = $this->getTableEngines();
        $return        = array();
        $totalDuration = 0;
        if (true === $isCli) {
            echo count($tables) . ' Tables' . PHP_EOL;
            flush();
        }
        foreach ($tables as $table) {
            $engine = (isset($engines[$table]) ? $engines[$table] : '');
            $method = '_optimize' . $engine;
            if (method_exists($this, $method)) {
                $start = microtime(true);
                $this->$method($table);
                $duration = microtime(true) - $start;
                $totalDuration += $duration;
                $output = "+ $table $engine " . sprintf('%.4f', $duration) . 's';
                if (true === $isCli) {
                    echo $output . PHP_EOL;
                    flush();
                }
                $return[] = $output;
            } else {
                $output = "- $table $engine";
                if (true === $isCli) {
                    echo $output . PHP_EOL;
                }
                $return[] = $output;
            }
        }
        if (true === $isCli) {
            printf('Total duration: %.4f seconds' . PHP_EOL, $totalDuration);
        }
        $return[] = $totalDuration;
        return $return;
    }

    /**
     * @param string $tableName
     */
    protected function _optimizeinnodb($tableName)
    {
        Mage::helper('zookal_tableopt')->getConnection()->changeTableEngine($tableName, 'InnoDB');
    }

    /**
     * @param string $tableName
     */
    protected function _optimizemyisam($tableName)
    {
        Mage::helper('zookal_tableopt')->getConnection()->query('OPTIMIZE TABLE `' . $tableName . '`');
    }

    /**
     * @return array
     */
    public function getTables()
    {
        $included = $this->getHelper()->getIncludedTables();
        if (count($included) > 0) {
            $included = array_flip($included);
            return $this->_getTables($included);
        }
        $excluded = array_flip($this->getHelper()->getExcludedTables());
        return $this->_getTables(null, $excluded);
    }

    /**
     * @param array $included null
     * @param array $excluded null
     *
     * @return array
     */
    protected function _getTables(array $included = null, array $excluded = null)
    {
        $return = array();
        foreach ($this->_tableStatuses as $table) {
            $t = $this->_getTable($table);
            if (null !== $included && isset($included[$table['Name']]) && $t) {
                $return[] = $t;
            } elseif (null !== $excluded && !isset($excluded[$table['Name']]) && $t) {
                $return[] = $t;
            }
        }
        return $return;
    }

    /**
     * @param array $table
     *
     * @return bool|string
     */
    protected function _getTable(array &$table)
    {
        $skippy = $this->getHelper()->isSkipEmptyTables();
        if (true === $skippy && $table['Rows'] > 0) {
            return $table['Name'];
        } elseif (false === $skippy) {
            return $table['Name'];
        }
        return false;
    }

    /**
     * @return array
     */
    public function getTableEngines()
    {
        $return = array();
        foreach ($this->_tableStatuses as $table) {
            $return[$table['Name']] = strtolower($table['Engine']);
        }
        return $return;
    }

    /**
     * @return array
     */
    protected function _initTableStatuses()
    {
        /** @var Varien_Db_Statement_Pdo_Mysql $result */
        $result               = Mage::helper('zookal_tableopt')->getConnection()->query('SHOW TABLE STATUS');
        $this->_tableStatuses = $result->fetchAll();
    }

    /**
     * @return Zookal_TableOpt_Helper_Data
     */
    public function getHelper()
    {
        if (!$this->_helper) {
            // @codeCoverageIgnoreStart
            $this->_helper = Mage::helper('zookal_tableopt');
        }
        // @codeCoverageIgnoreEnd
        return $this->_helper;
    }
}
