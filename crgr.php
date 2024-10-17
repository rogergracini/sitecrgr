<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once ('app/Mage.php');

if (file_exists('Preco.xml'))
    unlink('Preco.xml'); //unlink => apaga o arquivo já existente
if (file_exists('Produto.xml'))
    unlink('Produto.xml'); //unlink => apaga o arquivo já existente

echo "Baixando arquivo arq.zip ...";

// Usando cURL para baixar o arquivo
$url = "ftp://191.252.83.183/arq.zip";
$username = "palm20@galle";
$password = "Jequitiba1539!";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_FTP_USE_EPSV, false);
$downloaded_file = curl_exec($ch);
curl_close($ch);

$file = 'arq.zip';
file_put_contents($file, $downloaded_file);
echo "OK\n";

echo "Extraindo dados de arq.zip ...";

// Usando ZipArchive para descompactar
$zip = new ZipArchive;
if ($zip->open($file) === TRUE) {
    $zip->extractTo('./');
    $zip->close();
    echo "OK\n";
} else {
    echo "Erro ao descompactar o arquivo\n";
}




if ((filesize('Preco.xml') <= 0) || (filesize('Produto.xml') <= 0)) {
    echo "Erro ao baixar arquivos do FTP Galle...\n";
    die;
    //die => equvalente ao exit
}

use \Magento\Framework\App\Bootstrap;

$dir = '/home/u246762803/domains/crgr.com.br/public_html';

include_once ($dir . '/app/Mage.php');

$conn = new mysqli('localhost', 'u246762803_user_salomao', '2025Ewdfh1k7', 'u246762803_banco_salomao');
$conn->query("SET NAMES 'utf8'");
$conn->query('SET character_set_connection=utf8');
$conn->query('SET character_set_client=utf8');
$conn->query('SET character_set_results=utf8');

// <TabelaID_Int>592</TabelaID_Int>
// <ProdutoID_Int>01-001AG</ProdutoID_Int>
// <PrecoGrama>1</PrecoGrama>
// <Preco>2.75</Preco>

if (file_exists('crgr_processeds.arr'))
    $processeds = file_get_contents('crgr_processeds.arr');
else
    $processeds = '';

if (strlen(trim($processeds)) <= 0)
    $processeds = [];
else
    $processeds = explode(',', $processeds);

$file = fopen('Preco.xml', 'r');
$lines = [];
$start = false;
$lines_aux = [];
$sku = '';
$key = '';

while (!feof($file)) {
    $line = trim(fgets($file));
    if ($line == '<Row>') {
        $lines_aux = [];
        $start = true;
        $sku = '';
        $key = '';
        continue;
    } elseif ($line == '</Row>') {
        if (isset($lines[$key]) === false)
            $lines[$key] = [];

        $lines[$key][$sku] = $lines_aux[$key];
        $lines_aux = [];
        $start = false;
        continue;
    }

    if ($start === true) {
        $tmp = explode('<', $line, 2);
        $tmp = explode('>', $tmp[1], 2);
        $field_name = $tmp[0];

        $tmp = explode('<', $tmp[1], 2);
        $field_value = $tmp[0];

        if ($field_name == 'ProdutoID_Int')
            $sku = $field_value;
        if ($field_name == 'TabelaID_Int')
            $key = $field_value;

        if ((strlen(trim($key)) > 0) && (isset($lines_aux[$key]) === false)) {
            $lines_aux[$key] = [];
        }
        if (isset($lines_aux[$key]) === true) {
            $lines_aux[$key][$field_name] = $field_value;
        }
    }
}
fclose($file);

$file = fopen('Produto.xml', 'r');
$start = false;
$lines_aux = [];
$sku = '';

$tmp_keys = array_keys($lines);

foreach ($tmp_keys as $key) {
    fseek($file, 0);
    while (!feof($file)) {
        $line = trim(fgets($file));

        if ($line == '<Row>') {
            $lines_aux = [];
            $start = true;
            $sku = '';
            continue;
        } elseif ($line == '</Row>') {

            if (isset($lines[$key][$sku]) === true) {
                $lines[$key][$sku] = array_merge($lines[$key][$sku], $lines_aux[$key]);
            }

            $lines_aux = [];
            $start = false;

            continue;
        }

        if ($start === true) {
            $tmp = explode('<', $line, 2);
            $tmp = explode('>', $tmp[1], 2);
            $field_name = $tmp[0];

            $tmp = explode('<', $tmp[1], 2);
            $field_value = $tmp[0];

            if ($field_name == 'ProdutoID_Int')
                $sku = $field_value;
            if ($field_name == 'TabelaID_Int')
                $key = $field_value;

            if ((strlen(trim($key)) > 0) && (isset($lines_aux[$key]) === false)) {
                $lines_aux[$key] = [];
            }
            if (isset($lines_aux[$key]) === true) {
                $lines_aux[$key][$field_name] = $field_value;
            }

        }
    }
}
fclose($file);

$tables = [];

if (isset($lines['645']) === false) $lines['645'] = []; //TABELA 2024/010 PRATA 
if (isset($lines['646']) === false) $lines['646'] = []; //TABELA 2024/011 PRATA 
if (isset($lines['647']) === false) $lines['647'] = []; //TABELA 2024/012 PRATA

if (isset($lines['651']) === false) $lines['651'] = []; //TABELA 2024/026 FOLHEADO

if (isset($lines['627']) === false) $lines['627'] = []; //TABELA 2024/002 FOLHEADO(braRC)

$tables['4'] = array_merge($lines['645'], $lines['651']);

$tables['6'] = array_merge($lines['645'], $lines['627']);

$tables['8'] = array_merge($lines['646'], $lines['651']);

$tables['10'] = array_merge($lines['646'], $lines['627']);

$tables['12'] = array_merge($lines['647'], $lines['651']);

$tables['14'] = array_merge($lines['647'], $lines['627']);

$tables['16'] = array_merge($lines['647'], $lines['627']);

$magento_refs = [];
$magento_refs['4'] = 5;   //ID do magento 2024/020(x4) + 2024/001(x4) and 2024/020(x4) + 2024/001(x5)
$magento_refs['6'] = 7;   //ID do magento 2024/020(x4) + 2024/003(x4) and 2024/020(x4) + 2024/003(x5)
$magento_refs['8'] = 9;   //ID do magento 2024/021(x4) + 2024/001(x4) and 2024/021(x4) + 2024/001(x5)
$magento_refs['10'] = 11; //ID do magento 2024/021(x4) + 2024/003(x4) and 2024/021(x4) + 2024/003(x5)
$magento_refs['12'] = 13; //ID do magento 2024/022(x4) + 2024/001(x4) and 2024/022(x4) + 2024/003(x5)
$magento_refs['14'] = 15; //ID do magento 2024/022(x4) + 2024/003(x4) and 2024/022(x4) + 2024/003(x5)
$magento_refs['16'] = 17; //ID do magento 2024/022(x5) + 2024/003(x4) and 2024/022(x5) + 2024/003(x5)


$products = [];
foreach ($tables as $key_tables => $value_tables) {
    foreach ($value_tables as $key => $values) {
        if (isset($products[$key]) === false)
            $products[$key] = $values;
        if (isset($products[$key]['groups']) === false)
            $products[$key]['groups'] = [];

        array_push($products[$key]['groups'], [$key_tables, $values['Preco']]);
        array_push($products[$key]['groups'], [$magento_refs[$key_tables], $values['Preco']]);
    }
}

// file_put_contents('lixo.lxo',var_export($products,true));

foreach ($products as $sku => $value) {

    // [ProdutoID_Int] => 03-1585G1
    // [Descricao] => Anel Fundicao - 15 Zirconia - Meio c/ Pedra Cravada Metade c/ Pedra
    // [ImagemID] => 0/03-1585-1
    // [Peso] => 1.83
    // [GrupoID_Int] => 03
    // [LinhaID_Int] => 26
    // [MaterialID_Int] => 0 <= Folheado a Ouro
    // [MaterialID_Int] => 2 <= Prata
    // [TamanhoID_Int] => 3G
    // [CorID_Int] => 01
    // [TipoID_Int] => 00
    // [Largura_MM] => 1
    // [Altura_MM] => 1
    // [Lancamento] => 0
    // [LctoData] => 20130319
    // [Ativo] => False ou True
    // [TabelaID_Int] => 583
    // [PrecoGrama] => 0
    // [Preco] => 8.83

    if (($value['Ativo'] == 'False') || ($value['Ativo'] === false)) {
        echo 'SKU: ' . $sku . ' - Produto inativo (Ativo = False) - Ignorando' . "\n\n";
        continue;
    }

    if (in_array($sku, $processeds)) {
        echo 'SKU: ' . $sku . ' - Processado antes - ' . $value['Descricao'] . ' - ' . $value['TipoID_Int'] . ' - ' . $value['Largura_MM'] . 'mm x ' . $value['Altura_MM'] . 'mm - ' . $value['Peso'] . 'gr' . "\n\n";
        continue;
    }

    if (strpos($sku, 'BR') !== false) {
        echo 'SKU: ' . $sku . ' - ignorando o produto' . "\n\n";
        continue;
    }

    //if (strpos($sku,'04-5466HG2') === false) continue;

    $name = $value['Descricao'] . ' - ' . $value['TipoID_Int'] . ' - ' . $value['Largura_MM'] . 'mm x ' . $value['Altura_MM'] . 'mm - ' . $value['Peso'] . 'gr';
    $image = 'http://app.galle.com.br/images/grandes/' . $value['ImagemID'] . '.jpg';
    $image_name = explode('/', $value['ImagemID'])[1] . '.jpg';

    $weight = floatval($value['Peso']);
    $original_price = floatval($value['Preco']);

    $ver = explode('-', $sku)[0];
    $tipo_produto = (strpos($sku, 'AG') !== false) ? 'AG' : 'OURO';

    if ($value['PrecoGrama'] === '1')
        $weight_value = $weight;
    else
        $weight_value = 1;

    echo "Iniciando SKU do Produto: $sku \n";
    Mage::app('admin');
    $newStoreId = Mage_Core_Model_App::ADMIN_STORE_ID;
    var_dump($newStoreId);
    Mage::app()->setCurrentStore(Mage::getModel('core/store')->load($newStoreId));

    $get_product_id = Mage::getModel("catalog/product")->getIdBySku($sku);
    $set_product = Mage::getModel("catalog/product")->load($get_product_id);

    var_dump($get_product_id);


    if (($set_product === false) || (empty($set_product->getName()))) {
        $new_product = true;
        $set_product = Mage::getModel('catalog/product');
        echo "Inserindo novo produto\n";
    } else {
        echo "Atualizando produto: " . $set_product->getName() . "\n";
    }

    $set_product = Mage::getModel('catalog/product');
    $set_product = Mage::getModel("catalog/product")->load($get_product_id);

    echo "Baixando imagem: ";
    try {

        if (file_exists($dir . '/media/catalog') === false) {
            mkdir($dir . '/media/catalog');
            mkdir($dir . '/media/catalog/product');
        } elseif (file_exists($dir . '/media/catalog/product') === false) {
            mkdir($dir . '/media/catalog/product');
        }

        $imagePath = $dir . "/media/catalog/product/" . strtolower($image_name);
        $image_content = file_get_contents($image);

        if (strlen(trim($image_content)) <= 0) {
            echo "Baixar produto com erro de imagem :: " . $image . " - Continuando sem imagem...\n";
        } else {

            if (file_exists($imagePath) === false) {
                $image_exist = false;
                file_put_contents($imagePath, $image_content);
                echo "Produto de imagem baixado :: " . $imagePath . " - url: " . $image . "\n";
            } else {
                $image_exist = true;
                echo "a imagem já existe, ignorando :: " . $imagePath . " - url: " . $image . "\n";
            }
        }
    } catch (\Exception $e) {
        $image_content = '';
        echo "Baixar produto com erro de imagem :: " . $image . " - Continuando sem imagem...\n";
    }

    echo "Table: " . $key_tables . "/" . $magento_refs[$key_tables] . " - Sku: " . $sku . " - Name: " . $name . " - Price: " . $price_x4 . " - Peso: " . $weight . " - Orginal Price: " . $original_price . " - Price_X5: " . $price_x5 . "\n";

    $weight = (string) $weight;
    try {
        $urlkey = slug($name . ' ' . $sku);
        $set_product->setUrlKey($urlkey); //se o nome foi alterado por alguma coisa, o produto que está sendo atualizado não altera o slug

        $today_date = date("Y-m-d"); //Data de criação
        $new_date = date('Y-m-d', strtotime("+15 day")); //dias que o produto fica com status novo    

        $set_product->setWebsiteIds(1);
        $set_product->setStoreId(0);
        $set_product->setAttributeSetId(4);
        $set_product->setTypeId('simple');
        $set_product->setCreatedAt(strtotime('now'));
        $set_product->setNewsFromDate($today_date);
        $set_product->setNewsToDate($new_date);
        $set_product->setVisibility(4);
        $set_product->setManufacturer(28);
        $set_product->setSku($sku);
        $set_product->setTaxClassId(0);
        $set_product->setCountryOfManufacture('BR');
        $set_product->setStatus(1);
        $set_product->setName($name);
        $set_product->setDescription($name);
        $set_product->setShort_description($name);
        $set_product->setWeight($weight);

        echo "Definir estoque...\n";

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
                'notify_stock_qty' => 500,
                'is_in_stock' => '1',
                'qty' => 500,
            ]
        );

        $set_product->save(); // Isso irá forçar a atualização do estoque


        $code_x4 = (String) $key_tables;
        $code_x5 = (String) $magento_refs[$key_tables];

        $groupPrice = [];
        $hivalue = 0;
        foreach ($value['groups'] as $keygr => $valuegr) {


            $price_x4 = floatval($valuegr[1]) * 4 * $weight_value;
            $price_x5 = floatval($valuegr[1]) * 5 * $weight_value;

            if ($hivalue < $price_x4)
                $hivalue = $price_x4;
            if ($hivalue < $price_x5)
                $hivalue = $price_x5;

            if ((in_array($valuegr[0], $magento_refs) === true) && ($tipo_produto != 'AG')) {
                $pricegr = $price_x5;
                // echo $valuegr[0]."-----".$pricegr."-----X5\n";
            } else {
                $pricegr = $price_x4;
                // echo $valuegr[0]."-----".$pricegr."-----X4\n";
            }

            $groupPrice[] = [
                'website_id' => Mage::getModel('core/store')->load($price_data['store_id'])->getWebsiteId(),
                'cust_group' => $valuegr[0],
                'price' => floatVal($pricegr),
                "all_groups" => false
            ];
        }
        $set_product->setData('group_price', $groupPrice);

        $set_product->setPrice($hivalue);
        $set_product->setCost(null);
        $set_product->setSpecialPrice($hivalue);

        if ((strlen(trim($image_content)) != 0) && ($image_exist === false)) {
            $set_product->addImageToMediaGallery($imagePath, array('image', 'small_image', 'thumbnail'), false, false);
        }

        $set_product->save();

        file_put_contents('crgr_processeds.arr', ',' . $sku, FILE_APPEND);
        echo "Produto salvo... \n\n";

    } catch (Exception $e) {
        echo $sku . " < \n";
        echo $e->getMessage() . "\n\n";
    }
}
if (file_exists('crgr_processeds.arr'))
    unlink('crgr_processeds.arr');

function slug($string)
{
    $string = strtr(mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string)), 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    $string = strip_tags($string);
    $string = preg_replace('/[^A-Za-z0-9-]+/', ' ', $string);
    $string = trim($string);
    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $slug = strtolower($string);
    return $slug;
}