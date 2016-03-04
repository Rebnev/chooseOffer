<? if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

//main
use Bitrix\Main\Loader;
use Bitrix\Iblock;
use Bitrix\Currency;
if(!CModule::IncludeModule("iblock"))return;
$catalogIncluded = Loader::includeModule('catalog');
$iblockExists = (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0);

//types
$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

//iblocks
$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch()){
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
}


//properties
$arProperty = array();
$arProperty_N = array();
$arProperty_X = array();
if ($iblockExists)
{
	$propertyIterator = Iblock\PropertyTable::getList(array(
		'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
		'filter' => array('=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=ACTIVE' => 'Y'),
		'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
	));
	while ($property = $propertyIterator->fetch())
	{
		$propertyCode = (string)$property['CODE'];
		if ($propertyCode == '')
			$propertyCode = $property['ID'];
		$propertyName = '['.$propertyCode.'] '.$property['NAME'];

		if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
		{
			$arProperty[$propertyCode] = $propertyName;

			if ($property['MULTIPLE'] == 'Y')
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_LIST)
				$arProperty_X[$propertyCode] = $propertyName;
			elseif ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_ELEMENT && (int)$property['LINK_IBLOCK_ID'] > 0)
				$arProperty_X[$propertyCode] = $propertyName;
		}

		if ($property['PROPERTY_TYPE'] == Iblock\PropertyTable::TYPE_NUMBER)
			$arProperty_N[$propertyCode] = $propertyName;
	}
	unset($propertyCode, $propertyName, $property, $propertyIterator);
}


//offers properties
$offers = false;
$arProperty_Offers = array();
$arProperty_OffersWithoutFile = array();
if ($catalogIncluded && $iblockExists)
{
	$offers = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	if (!empty($offers))
	{
		$propertyIterator = Iblock\PropertyTable::getList(array(
			'select' => array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE'),
			'filter' => array('=IBLOCK_ID' => $offers['IBLOCK_ID'], '=ACTIVE' => 'Y', '!=ID' => $offers['SKU_PROPERTY_ID']),
			'order' => array('SORT' => 'ASC', 'NAME' => 'ASC')
		));
		while ($property = $propertyIterator->fetch())
		{
			$propertyCode = (string)$property['CODE'];
			if ($propertyCode == '')
				$propertyCode = $property['ID'];
			$propertyName = '['.$propertyCode.'] '.$property['NAME'];

			$arProperty_Offers[$propertyCode] = $propertyName;
			if ($property['PROPERTY_TYPE'] != Iblock\PropertyTable::TYPE_FILE)
				$arProperty_OffersWithoutFile[$propertyCode] = $propertyName;
		}
		unset($propertyCode, $propertyName, $property, $propertyIterator);
	}
}

//price
$arPrice = array();
if ($catalogIncluded){
	$arSort = array_merge($arSort, CCatalogIBlockParameters::GetCatalogSortFields());
	$arPrice = CCatalogIBlockParameters::getPriceTypesList();
}else{
	$arPrice = $arProperty_N;
}


//sort
$arSort = CIBlockParameters::GetElementSortFields(
	array('SHOWS', 'SORT', 'TIMESTAMP_X', 'NAME', 'ID', 'ACTIVE_FROM', 'ACTIVE_TO'),
	array('KEY_LOWERCASE' => 'Y')
);

//order
$arAscDesc = array(
	"asc" => GetMessage("ASC"),
	"desc" => GetMessage("DESC"),
);

$arComponentParameters = array(
	"GROUPS" => array(
		"OFFERS" => array(
			"NAME" => GetMessage('OFFERS')
		),
		"PRICE" => array(
			"NAME" => GetMessage('PRICE')
		),
	),
	"PARAMETERS" => array(
		
		//выбор инфоблока нужен для выбора свойств для вывода
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "catalog",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"ADDITIONAL_VALUES" => "N",
			"REFRESH" => "Y",
		),
		
		//передаем ID продукта, чтобы определить, есть ли у него предложения или нет
		"PRODUCT_ID" => array(
			"NAME" => GetMessage("PRODUCT_ID"),
			"TYPE" => "STRING",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"PARENT" => "BASE",
		),
		
		
		//свойства товара, например если у товара нет предложений и у него все же есть свойства для выбора (условные предложения)
		"PROPERTY_CODE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("IBLOCK_PROPERTY"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty,
			"ADDITIONAL_VALUES" => "Y",
		),
		//выбираем тип цен
		"PRICE_CODE" => array(
			"PARENT" => "PRICE",
			"NAME" => GetMessage("PRICE_CODE"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arPrice,
		),
		
		"OFFERS_FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("OFFERS_FIELDS"), "OFFERS"),
		
		"OFFERS_PROPERTY_CODE" => array(
			"PARENT" => "OFFERS",
			"NAME" => GetMessage("OFFERS_PROPERTIES"),
			"TYPE" => "LIST",
			"MULTIPLE" => "Y",
			"VALUES" => $arProperty_Offers,
			"ADDITIONAL_VALUES" => "Y",
		),
		"OFFERS_SORT_FIELD" => array(
			"PARENT" => "OFFERS",
			"NAME" => GetMessage("OFFERS_SORT_FIELD"),
			"TYPE" => "LIST",
			"VALUES" => $arSort,
			"ADDITIONAL_VALUES" => "Y",
			"DEFAULT" => "sort",
		),
		"OFFERS_SORT_ORDER" => array(
			"PARENT" => "OFFERS",
			"NAME" => GetMessage("OFFERS_SORT_ORDER"),
			"TYPE" => "LIST",
			"VALUES" => $arAscDesc,
			"DEFAULT" => "asc",
			"ADDITIONAL_VALUES" => "Y",
		),
		
		"CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		
		
	),

);
?>