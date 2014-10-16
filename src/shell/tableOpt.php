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

require_once 'abstract.php';

class Zookal_Table_Opt extends Mage_Shell_Abstract
{

    /**
     * Run script
     *
     */
    public function run()
    {
        if ($this->getArg('run')) {

            $result = Mage::getModel('zookal_tableopt/optimize')->setCli(true)->run();
            $t      = 'Tables NOT optimized';
            if ($result) {
                $t = 'Tables optimized';
            }
            echo $t . PHP_EOL;
        } elseif ($this->getArg('status')) {
            echo 'Status Ok' . PHP_EOL;
        } else {
            echo $this->usageHelp();
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f tableOpt.php -- [options]
        php -f tableOpt.php -- run

  run               Runs the optimization process
  status            Display statistics per table
  help              This help

USAGE;
    }
}

$shell = new Zookal_Table_Opt();
$shell->run();
