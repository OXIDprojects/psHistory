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
class psHistory_Order_Remark extends psHistory_Order_Remark_parent
{
    /**
     * Executes parent method parent::render(), creates oxorder and
     * oxlist objects, passes it's data to Smarty engine and returns
     * name of template file "user_remark.tpl".
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $soxId = $this->getEditObjectId();
        $sRemoxId = oxRegistry::getConfig()->getRequestParameter( "rem_oxid");
        if ( $soxId != "-1" && isset( $soxId)) {
            $oOrder = oxNew( "oxorder" );
            $oOrder->load( $soxId);

            // all remarks
            $oRems = oxNew( "oxlist" );
            $oRems->init( "oxremark");
            $sSelect = "select * from oxremark where oxparentid=".oxDb::getDb()->quote( $oOrder->oxorder__oxuserid->value )." order by oxcreate desc";
            $oRems->selectString( $sSelect );
            foreach ($oRems as $key => $val) {
                if ( $val->oxremark__oxid->value == $sRemoxId) {
                    $val->selected = 1;
                    $oRems[$key] = $val;
                    break;
                }
            }

            $this->_aViewData["allremark"] = $oRems;

            if ( isset( $sRemoxId)) {
                $oRemark = oxNew( "oxRemark" );
                $oRemark->load( $sRemoxId);
                $this->_aViewData["remarkheader"]    = $oRemark->oxremark__oxheader->value;

                // psHistory | start
                $this->_aViewData["remarktext"] = str_replace("&lt;br&gt;", "\r\n", $oRemark->oxremark__oxtext->value);


                $oUser = oxnew("oxuser");
                if($oUser->load($oRemark->oxremark__pshistory_userid->value))
                {
                    $this->_aViewData["username"] = $oUser->oxuser__oxfname->value.' '.$oUser->oxuser__oxlname->value;
                }
                // psHistory | end
            }

            // psHistory | start
            $oConfig = $this->getConfig();
            $this->_aViewData["pshistory_status"] = $oConfig->getConfigParam("psHistoryMain_status");
            $this->_aViewData["pshistory_signature"] = $oConfig->getConfigParam("psHistoryMain_signature");
            $this->_aViewData["pshistory_subject"] = $oOrder->oxorder__oxordernr->value;
            $this->_aViewData["pshistory_mailto"] = $oOrder->oxorder__oxbillemail->value;
            // psHistory | end
        }

        return "pshistory_order_remark.tpl";
    }

    /**
     * Saves order history item text changes.
     *
     * @return string
     */
    public function save()
    {
        $oOrder = oxNew( "oxorder" );
        if ( $oOrder->load( $this->getEditObjectId() ) ) {
            $oRemark = oxNew( "oxremark" );
            $oRemark->load( oxRegistry::getConfig()->getRequestParameter( "rem_oxid" ) );

            // psHistory | start
            $sText = oxRegistry::getConfig()->getRequestParameter( "remarktext" );
            $sStatus = oxRegistry::getConfig()->getRequestParameter( "pshistory_status" );

            // send mail?
            if(oxRegistry::getConfig()->getRequestParameter( "pshistory_sendmail" ))
            {
                $sMailTo        = oxRegistry::getConfig()->getRequestParameter( "pshistory_mailto" );
                $sMailSubject   = oxRegistry::getConfig()->getRequestParameter( "pshistory_subject" );
                $sTextNew       = $sMailTo.' ('.$sMailSubject.')<br>';
                $sTextNew      .= '<br>------------------------------------------------------------------------------------------------------------<br><br>';
                $sTextNew      .= $sText;

                $oEmail = oxNew( 'oxemail' );
                if ( $oEmail->sendEmail( $sMailTo, $sMailSubject, $sText ) )
                {
                    oxRegistry::get("oxUtilsView")->addErrorToDisplay( '<span style="color: green;">'.oxRegistry::getLang()->translateString('PSHISTORY_ORDERREMARK_SENDMAIL_SUCCESS').'</span>' );
                }
                else
                {
                    oxRegistry::get("oxUtilsView")->addErrorToDisplay( oxRegistry::getLang()->translateString('PSHISTORY_ORDERREMARK_SENDMAIL_ERROR') );
                }

                $sText = $sTextNew;
            }

            $oRemark->oxremark__oxtext = new oxField( $sText );
            $oRemark->oxremark__oxtype = new oxField( ($sStatus ? "psH" : "r") );
            $oRemark->oxremark__pshistory_status = new oxField( $sStatus );
            $oRemark->oxremark__pshistory_userid = new oxField( $this->getUser()->getId() );
            // psHistory | end

            $oRemark->oxremark__oxheader = new oxField( oxRegistry::getConfig()->getRequestParameter( "remarkheader" ) );
            $oRemark->oxremark__oxparentid = new oxField( $oOrder->oxorder__oxuserid->value );
            $oRemark->save();
        }
    }

}