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

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'           => 'psHistory',
    'title'        => 'psHistory',
    'description'  => array(
        'de' => 'Individuelle Stati f&uuml;r Bestellungen, sowie eMails aus dem Shop-Admin direkt an den Kunden senden.',
        'en' => 'Individual status information for orders / Sending mails directly from shop admin to customer',
    ),
    'thumbnail'    => 'logo_pc-os.jpg',
    'version'      => '1.1.0',
    'author'       => 'Proud Sourcing GmbH',
    'url'          => 'http://www.proudcommerce.com',
    'email'        => 'support@proudcommerce.com',
    'extend'       => array(
        'order_remark'    =>      'proudsourcing/psHistory/application/controllers/admin/pshistory_order_remark'
    ),
    'files' => array(
        'pshistory_setup'  => 'proudsourcing/psHistory/core/pshistory_setup.php',
    ),
    'templates' => array(
        'pshistory_order_remark.tpl'    =>      'proudsourcing/psHistory/application/views/admin/tpl/pshistory_order_remark.tpl'
    ),
    'blocks' => array(
    ),
    'settings' => array(
        array('group' => 'psHistoryMain', 'name' => 'psHistoryMain_status', 'type' => 'arr', 'value' => array('Kundennotiz', 'Nachfrage'), 'position' => 1),
        array('group' => 'psHistoryMain', 'name' => 'psHistoryMain_signature', 'type' => 'arr', 'value' => array('Meine', 'Signatur'), 'position' => 2),
    ),
    'events' => array(
        'onActivate' => 'pscmssnippets_setup::onActivate',
    ),
);