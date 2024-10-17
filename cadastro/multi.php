

<?php

$installer = $this;
$attribute  = array(
    'type' => 'int',
    'input' => 'text',
    'label' => 'Is Active',
    'global' => 1,
    'visible' => 1,
    'default' => '0',
    'required' => 0,
    'user_defined' => 0,
    'used_in_forms' => array(
        'adminhtml_customer',
    ),
    'comment' => 'Multiplicador da prata',
); 

$installer->addAttribute('customer', 'multiplicador_prata', $attribute);

 Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'multiplicador_prata')
    ->setData('used_in_forms', array('adminhtml_customer'))
    ->save();

$installer->endSetup();


?>
