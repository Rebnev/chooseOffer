<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Loader;
use Bitrix\Currency\CurrencyTable;

$APPLICATION->AddHeadScript("/bitrix/components/makeitda/choose.offers/js/offers.js");


//время кеширования
if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

unset($arParams["IBLOCK_TYPE"]); //was used only for IBLOCK_ID setup with Editor
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);






//sorting default is wrong
if (empty($arParams["OFFERS_SORT_FIELD"]))
	$arParams["OFFERS_SORT_FIELD"] = "sort";
if (!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["OFFERS_SORT_ORDER"]))
	$arParams["OFFERS_SORT_ORDER"] = "asc";

//лимит на вывод количества предложений
if(!$arParams["OFFERS_LIMIT"]){
	//все
	$arParams["OFFERS_LIMIT"] = 0;	
}

//Единая цена на все предложения, не нужно получать при отсутствии было предложения цену от и до
$arParams["OFFERS_ONE_PRICE"] = $arParams["OFFERS_ONE_PRICE"] !== "N";


//НДС включен или нет
$arParams["PRICE_VAT_INCLUDE"] = $arParams["PRICE_VAT_INCLUDE"] !== "N";


//группа кеширования
$arParams['CACHE_GROUPS'] = trim($arParams['CACHE_GROUPS']);
if ('N' != $arParams['CACHE_GROUPS'])
	$arParams['CACHE_GROUPS'] = 'Y';


/*************************************************************************
			Пока нет работы с ссылкой на покупку, потом можно будет сделать
*************************************************************************/


/*

нужно забрать предложения выбранные их поля,
если предложений нет, значит забрать информацию о самом товаре.


*/








/*************************************************************************
			Work with cache
*************************************************************************/
if($this->StartResultCache(false, array($arrFilter, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))){
	$arResult = array();
	$arResult['SELECTED_OFFER'] = false;
	$arResult['OFFERS'] = false;
	$arResult['PRODUCT'] = false;
	global $CACHE_MANAGER;
	
	
	//если запрашиваемый элемент с ID
	$arResult['PRODUCT_ID'] = false;
	$res = CIBlockElement::GetByID($arParams["PRODUCT_ID"]);
	if($product = $res->GetNext()){
		$arResult['PRODUCT_ID'] = $product['ID'];
	}
	if(!$arResult['PRODUCT_ID']){
		$this->AbortResultCache();
		ShowError(GetMessage("NOTFOUND"));
		return;
	}

	
	
	
	//цены
	$arResult["PRICES"] = CIBlockPriceTools::GetCatalogPrices($arParams["IBLOCK_ID"], $arParams["PRICE_CODE"]);
	$arResult['PRICES_ALLOW'] = CIBlockPriceTools::GetAllowCatalogPrices($arResult["PRICES"]);
	if (!empty($arResult['PRICES_ALLOW'])){
		$boolNeedCatalogCache = CIBlockPriceTools::SetCatalogDiscountCache($arResult['PRICES_ALLOW'], $USER->GetUserGroupArray());
	}
	
	//filter selected
	$arFilter = array();
	$arSelect = array("ID","IBLOCK_ID");
	
	//add filter price
	foreach($arResult["PRICES"] as $value){
		if (!$value['CAN_VIEW'] && !$value['CAN_BUY'])continue;
		$arSelect[] = $value["SELECT"];
	}
	
	//массив в котором хранятся только свойства нужные
	$arResult['OFFERS_SELECT'] = array();
	
	//получаем данные, если ли инфоблок предложений или нет, если есть получаем предложения,
	//если нет, то работаем с единичным товаром
	$productParent = CCatalogSku::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
	

	if($productParent && intval($productParent['IBLOCK_ID'])){
		//свойства предложения являются определяющий фактором выбора
		//потому все свойства мы запишем в массив
		
		//в этом массиве можно будет по ID предложения получить его цену
		$arResult['OFFERS_PRICE'] = array();
		//типо цен может быть много и нам нужно полусить максимальную и минимальную стоимость для каждого типацены
		$arResult['OFFERS_MIN_MAX_PRICE'] = array();
		
		//есть предложения	
		$fieldsSelect = array_merge($arSelect,$arParams['OFFERS_FIELD_CODE']);
		$arFilter = array_merge($arFilter,array("IBLOCK_ID" => $productParent['IBLOCK_ID'], "ACTIVE"=>"Y", 'PROPERTY_'.$productParent['SKU_PROPERTY_ID'] => $arResult['PRODUCT_ID']));
		$arResult['OFFERS'] = CIBlockPriceTools::GetOffersArray(
			intval($productParent['PRODUCT_IBLOCK_ID']),
			array($arResult['PRODUCT_ID']),
			array(),
			$fieldsSelect,
			$arParams['OFFERS_PROPERTY_CODE'],
			$arParams["OFFERS_LIMIT"],
			$arResult["PRICES"],
			$arParams['PRICE_VAT_INCLUDE']
		);
		$arResult['OFFERS_SELECT'] = array();
		foreach($arResult['OFFERS'] as $k=>&$v){
			
			$arResult['OFFERS_PRICE'][$v['ID']] = $v['PRICES'];
			
			//min max price
			foreach($v['PRICES'] as $kk => $vv){
				if(!isset($arResult['OFFERS_MIN_MAX_PRICE'][$kk])){
					$arResult['OFFERS_MIN_MAX_PRICE'][$kk] = array('MIN' => false, 'MAX' => false);
				}
				//определяем какю цену получаем, с учетом налога или нет
				$vatPrice = $vv['VALUE_VAT'];
				if($arParams["PRICE_VAT_INCLUDE"] == 'N'){
					$vatPrice = $vv['VALUE_NOVAT'];
				}
				
				//min
				if(!$arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MIN'] || $arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MIN'] > $vatPrice){
					$arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MIN'] = $vatPrice;
				}
				
				//max
				if(!$arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MAX'] || $arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MAX'] < $vatPrice){
					$arResult['OFFERS_MIN_MAX_PRICE'][$kk]['MAX'] = $vatPrice;
				}
			}
			

			//если цена единая на все предложения, берем по максимальной
			if($arParams["OFFERS_ONE_PRICE"]){
				$tempP = array();
				foreach($arResult['OFFERS_MIN_MAX_PRICE'] as $kk=>$vv){
					$tempP[$kk] = $vv['MAX'];
				}
				$arResult['OFFERS_MIN_MAX_PRICE'] = $tempP;
			}
			
			
			//массив вкотором зранятся значения учавствующие в выборе конкретного предложения
			$v['OFFER_PROPERTIES'] = array();
			
			
			
			foreach($v['PROPERTIES'] as $kk=>$vv){
				
				if(array_search($kk,$arParams['OFFERS_PROPERTY_CODE']) !== false){
					$v['OFFER_PROPERTIES'][$kk] = $vv;
					
					//значит это выбранное свойство, оно нужно для определения торгового предложения
					
					if(!$arResult['OFFERS_SELECT'][$kk]){
						$arResult['OFFERS_SELECT'][$kk] = array('NAME'=>$vv['NAME'],'VALUE'=>array());
					}
					
					
					
					$property = &$arResult['OFFERS_SELECT'][$kk]['VALUE'];
					
					//массив PROPERTIES для того, чтобы была возможность добавить дополнительные поля
					$propertyName = Cutil::translit($vv['VALUE'],"ru");
									
					if(!isset($arResult['OFFERS_SELECT'][$kk]['VALUE'][$propertyName])){
						$arResult['OFFERS_SELECT'][$kk]['VALUE'][$propertyName] = array('NAME' => $vv['VALUE'],"PROPERTIES" => array(),'ID' => array());
					}
					
					$property[$propertyName]['ID'][] = $v['ID'];
					//var_dump($vv);
					
					//добавляем значение, если не существует
					/*if(!isset($arResult['OFFERS_SELECT'][$kk]['VALUE'][$vv['ID']]['VALUE'])){
						$arResult['OFFERS_SELECT'][$kk]['VALUE'][$vv['ID']] = array('VALUE'=>$vv['VALUE'],'OFFERS' => array());
					}
					$arResult['OFFERS_SELECT'][$kk]['VALUE'][$vv['ID']]['OFFERS'][] = $v['ID'];*/
					//var_dump($arResult['OFFERS_SELECT'][$kk]['VALUE']);
					
					
					unset($property);
				}
			}
			unset($v);
		}
		//массив с ценами, для того чтобы JS мог возвращать цену к конктерному товару
		$prices = array();
		
		//меняем немгного формат и переставляем значения  ID в ключ массива
		$tempOff = array();
		foreach($arResult['OFFERS'] as $k=>$v){
			//если не единая цена, то собираем все цены на каждое предлождение
			if(!$arParams["OFFERS_ONE_PRICE"]){
				$prices[$v['ID']] = $v['PRICES'];
			}
			$tempOff[$v['ID']] = $v;
		}
		$arResult['OFFERS'] = $tempOff;
		
		$arResult['OFFERS_PRICES'] = false;
		//если не единая цена, то возвращаем массив с ценами
		if(!$arParams["OFFERS_ONE_PRICE"]){
			$arResult['OFFERS_PRICES'] = $prices;
		}
		$arResult['OFFERS_PRICES_JS'] = Cutil::PhpToJSObject($arResult['OFFERS_PRICES']);

	}else{
		//единичный товар	
	}
	
	//var_dump($arResult['OFFERS_SELECT']);
	
	$arResult['WRAPPER'] = md5(rand(0,1000));
	//TSVETOSNOVNOY
	
	
	
	/*if(!$arResult['OFFERS'] && !$arResult['PRODUCT']){
		//error nothing found
		$this->AbortResultCache();
		ShowError(GetMessage("NOTFOUND"));
		return;
	}*/

	

	
	
	
	//не удалять
	/*if (!$res){
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}*/
	










	$this->SetResultCacheKeys(array());
	$this->IncludeComponentTemplate();


}
?>