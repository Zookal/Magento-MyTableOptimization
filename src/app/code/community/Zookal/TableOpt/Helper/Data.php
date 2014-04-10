<?php

/**
 * @category    Zookal_TableOpt
 * @package     Helper
 * @author      Cyrill Schumacher | {firstName}@{lastName}.fm | @SchumacherFM
 * @copyright   Copyright (c) Zookal Pty Ltd
 * @license     OSL - Open Software Licence 3.0 | http://opensource.org/licenses/osl-3.0.php
 */
class Zookal_TableOpt_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @var Mage_Core_Model_Store
     */
    protected $_store;

    /**
     * @param Mage_Core_Model_Store $store
     */
    public function __construct(Mage_Core_Model_Store $store = null)
    {
        $this->_store = $store;
    }

    /**
     * @return Mage_Core_Model_Store
     */
    public function getStore()
    {
        if (!$this->_store) {
            // @codeCoverageIgnoreStart
            $this->_store = Mage::app()->getStore();
        }
        // @codeCoverageIgnoreEnd
        return $this->_store;
    }

    /**
     * @return array
     */
    public function getIncludedTables()
    {
        $value = trim($this->getStore()->getConfig('system/zookaltableopt/tables_include'));
        if (true === empty($value)) {
            return array();
        }
        return explode(',', $value);
    }

    /**
     * @return array
     */
    public function getExcludedTables()
    {
        $value = trim($this->getStore()->getConfig('system/zookaltableopt/tables_exclude'));
        if (true === empty($value)) {
            return array();
        }
        return explode(',', $value);
    }

    /**
     * @return bool
     */
    public function isSkipEmptyTables()
    {
        return (int)$this->getStore()->getConfig('system/zookaltableopt/skip_empty_tables') === 1;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return (int)$this->getStore()->getConfig('system/zookaltableopt/is_active') === 1;
    }
}