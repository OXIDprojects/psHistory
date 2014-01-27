<?php
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
    'thumbnail'    => '',
    'version'      => '1.0.0',
    'author'       => 'Proud Sourcing GmbH',
    'url'          => 'http://www.proudcommerce.com',
    'email'        => 'support@proudcommerce.com',
    'extend'       => array(
        'order_remark'    =>      'proudsourcing/psHistory/application/controllers/admin/pshistory_order_remark'
    ),
    'files' => array(
    ),
    'templates' => array(
        'pshistory_order_remark.tpl'    =>      'proudsourcing/psHistory/application/views/admin/tpl/pshistory_order_remark.tpl'
    ),
    'blocks' => array(
    ),
    'settings' => array(
        array('group' => 'psHistoryMain', 'name' => 'psHistoryMain_status', 'type' => 'arr', 'value' => array('Kundennotiz', 'Nachfrage'), 'position' => 1),
        array('group' => 'psHistoryMain', 'name' => 'psHistoryMain_signature', 'type' => 'arr', 'value' => array('Meine', 'Signatur'), 'position' => 2),
    )
);