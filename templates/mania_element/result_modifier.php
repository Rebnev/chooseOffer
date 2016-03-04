<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("sale");





//проверяем есть ли предложение в корзине
$offersID = array();
foreach($arResult['OFFERS'] as $k=>$v){$offersID[] = $v['ID'];}

$dbBasketItems = CSaleBasket::GetList(
     array(),
     array(
			  "FUSER_ID" => CSaleBasket::GetBasketUserID(),
			  "LID" => SITE_ID,
			  "ORDER_ID" => "NULL"
		   ),
     false,
     false,
     array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
);

$offersInCart = array();
while ($arItems = $dbBasketItems->Fetch()){$offersInCart[] = $arItems['PRODUCT_ID'];}
foreach($arResult['OFFERS'] as $k=>&$v){
	$v['IN_CART'] = false;	
	if(array_search($v['ID'],$offersInCart) != false){$v['IN_CART'] = true;}
	unset($v);
}



$colors = array();
$sizes = array();
$sizeTable = array();
	




foreach($arResult['OFFERS'] as $k=>$v){

	//colors
	array_push($colors,$v['PROPERTIES']["TSVETOSNOVNOY"]['VALUE']);
	//sizes
	$prop = &$arResult['OFFERS_SELECT']['RAZMER']['VALUE'][Cutil::translit($v['PROPERTIES']['RAZMER']['VALUE'])]['PROPERTIES'];
	
	$prop['Q'] = $v['CATALOG_QUANTITY'];
	$prop['IN_CART'] = $v['IN_CART'];
	unset($prop);

}



$arResult['SIZES'] = $sizes;

//ALL SIZES
$arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => 40, 'NAME' => array_keys($arResult['SIZES']));
$res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement()){ 
	$f = $ob->GetFields();
	$el = $ob->GetProperties(); 
	$prop = array();   
	foreach($el as $k=>$v){
		$prop[$k] = $v['VALUE'];
	}
	if(!$arResult['SIZE_TABLE_FROW']){
		$arResult['SIZE_TABLE_FROW'] = $prop;
	}
	
	$sizeTable[$f['NAME']]  = $prop;  
}

$arResult['SIZE_TABLE'] = $sizeTable;

if(!empty($colors)){
	
	
	$colorsRes = array();
	$arSelect = Array("ID", "IBLOCK_ID", "NAME","PREVIEW_PICTURE");
	$arFilter = Array("IBLOCK_ID" => 37, 'NAME' => $colors);
	$res = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()){ 
		$el = $ob->GetFields();
		$el['PREVIEW_PICTURE'] = CFile::ResizeImageGet($el['PREVIEW_PICTURE'], array('width'=>40, 'height'=>40), BX_RESIZE_IMAGE_EXACT, true);          
		$colorsRes[Cutil::translit($el['NAME'],'ru')] = $el;
	}
	foreach($arResult['OFFERS_SELECT']['TSVETOSNOVNOY']['VALUE'] as $k => &$v){
		if($colorsRes[$k]){
			$v['PROPERTIES']['PREVIEW_PICTURE'] = $colorsRes[$k]['PREVIEW_PICTURE'];
			$v['PROPERTIES']['ID'] = $colorsRes[$k]['ID'];
		}else{
			$v['PROPERTIES'] = false;
		}
		
		unset($v);
	}
	
}
