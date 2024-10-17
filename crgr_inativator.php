<?php

echo "Iniciando desativação....\n";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('app/Mage.php');

if (file_exists('inativo.txt') === false) {
    echo "Arquivo inativo.txt não encontrado....\n\n";
    die;
}

echo "Arquivo de skus encontrado....\n";

use \Magento\Framework\App\Bootstrap;

$dir = '/home/u246762803/domains/crgr.com.br/public_html';

include_once($dir.'/app/Mage.php');

echo "Lib magento carregado....\n";

$conn = new mysqli('localhost', 'u246762803_user_salomao', '2025Ewdfh1k7', 'u246762803_banco_salomao');
$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');

echo "Conectado no mysql....\n";

// <TabelaID_Int>592</TabelaID_Int>
// <ProdutoID_Int>01-001AG</ProdutoID_Int>
// <PrecoGrama>1</PrecoGrama>
// <Preco>2.75</Preco>

if (file_exists('crgr_processeds_inactive.arr')) $processeds = file_get_contents('crgr_processeds_inactive.arr');
else $processeds = '';

echo "Arquivo de processados verificado....\n";

if (strlen(trim($processeds))<=0) $processeds = [];
else $processeds = explode(',',$processeds);

$file = fopen('inativo.txt','r');
$skus_to_inactivate = [];
$first_line = true;

echo "Arquivo de skus aberto....\n";

while(!feof($file)) {
    if ($first_line === true) {
        $first_line = false;
        continue;
    }

    $line = trim(fgets($file));
    $sep = explode(' ',$line);

    $skus_to_inactivate[] = strtolower(trim($sep[0]));
}
fclose($file);

echo "Iniciando desativações....\n";

foreach ($skus_to_inactivate as $sku_i => $value_i) {
    $sku = $value_i;

    if (in_array($sku,$processeds)) {
        echo 'SKU: '.$sku.' - Processado antes'.  "\n\n";
        continue;
    }

    //if (strpos($sku,'04-5466HG2') === false) continue;
    
    echo "Iniciando SKU do Produto: $sku \n";

    Mage::app('admin');
    $newStoreId = Mage_Core_Model_App::ADMIN_STORE_ID;
    Mage::app()->setCurrentStore(Mage::getModel('core/store')->load($newStoreId));

    $get_product_id = Mage::getModel("catalog/product")->getIdBySku($sku);
    $set_product = Mage::getModel("catalog/product")->load($get_product_id);

    var_dump($get_product_id);

    if (($set_product === false) || (empty($set_product->getName()))) {
        $new_product = true;
        $set_product = Mage::getModel('catalog/product');
        echo "Produto não existe \n";
        continue;
    }
    
    echo "Desativando produto: ".$set_product->getName()."\n";
    
    $set_product = Mage::getModel('catalog/product');
    $set_product = Mage::getModel("catalog/product")->load($get_product_id);

    try {
        $set_product->setWebsiteIds(1);
        $set_product->setStoreId(0);
        $set_product->setVisibility(4); 
        $set_product->setManufacturer(28); 
        $set_product->setSku($sku);
        $set_product->setStatus(2);

        echo "Setando estoque 0 no produto...\n";

         $set_product->setStockData(
            [
                'use_config_manage_stock' => 0, 
                'use_config_min_qty' => 1,
                'use_config_min_sale_qty' => 1,
                'use_config_max_sale_qty' => 1,
                'use_config_backorders' => 1,
                'use_config_notify_stock_qty' => 1,
                'manage_stock' => 1,
                'min_sale_qty' => 0,
                'min_qty' => 0,
                'max_sale_qty' => 100000, 
                'is_qty_decimal' => 0,
                'backorders' => 0,
                'notify_stock_qty' => 5000,
                'is_in_stock' => '1', 
                'qty' => 0,
            ]
            );

        $set_product->save(); // Isso irá forçar a atualização do estoque        
        
        file_put_contents('crgr_processeds_inactive.arr',','.$sku,FILE_APPEND);
        echo "Product desativado... \n\n";

    }
    catch(Exception $e)
    {
        echo $sku." < \n";
        echo $e->getMessage()."\n\n";
    }
}
if (file_exists('crgr_processeds_inactive.arr')) unlink('crgr_processeds_inactive.arr');
