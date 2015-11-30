<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @copyright (c) Proud Sourcing GmbH | 2015
 * @link www.proudcommerce.com
 * @package psHistory
 * @version 1.1.0
 **/
class pshistory_setup extends oxSuperCfg
{
    /**
     * Setup routine
     */
    public static function onActivate() {
        $db = oxDb::getDb();
        try {
            if(!self::dbColumnExist('oxremark', 'pshistory_status')) {
                $db->Execute("ALTER TABLE  oxremark ADD  pshistory_status VARCHAR( 200 ) NOT NULL, ADD  pshistory_userid VARCHAR( 200 ) NOT NULL");
                $db->Execute("ALTER TABLE  oxremark CHANGE  OXTYPE  OXTYPE ENUM( 'o',  'r',  'n',  'c', 'psH' ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT  'r' COMMENT  'Record type: o - order, r - remark, n - neswletter, c - registration, psH - psHistory';");
            }

            // clear tmp dir
            self::emptyTmp();
            // generate views
            self::genViews();
        } catch (Exception $ex) {
            error_log("Error activating module: " . $ex->getMessage());
        }
    }
    /**
     * Teardown routine
     */
    public static function onDeactivate() {

    }

    /**
     * Generate DB views
     */
    public static function genViews()
    {
        $oShop = oxNew('oxShop');
        if ($oShop->load(oxRegistry::getConfig()->getShopId())) {
            $oShop->generateViews();
        }
    }

    /**
     * @param $sTable
     * @param $sColumn
     * @return string
     */
    public static function dbColumnExist($sTable, $sColumn) {
        $oDb = oxDb::getDb();
        $sDbName = oxRegistry::getConfig()->getConfigParam('dbName');
        try {
            $sSql = "SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? "
                . " AND COLUMN_NAME = ?";

            $blRet = $oDb->getOne($sSql, array($sDbName, $sTable, $sColumn));
        }
        catch(Exception $oEx) {
            $blRet = false;
        }
        return $blRet;
    }

    /**
     * Empty temp dir
     */
    public static function emptyTmp() {
        $tmpdir = oxRegistry::getConfig()->getConfigParam('sCompileDir');
        $d = opendir($tmpdir);
        while (($filename = readdir($d) ) !== false) {
            $filepath = $tmpdir . $filename;
            if (is_file($filepath)) {
                unlink($filepath);
            }
        }
    }
}