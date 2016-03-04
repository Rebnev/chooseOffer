<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("CHOOSE_OFFERS_NAME"),
	"DESCRIPTION" => GetMessage("CHOOSE_OFFERS_DESC"),
	"ICON" => "/images/choose_offers.gif",
	"PATH" => array(
		"ID" => GetMessage("MAKEIT"),
		"CHILD" => array(
			"ID" => "catalog",
			"NAME" => GetMessage("CHOOSE_OFFERS_CATALOG"),
			"SORT" => 30
		)
	),
);
?>