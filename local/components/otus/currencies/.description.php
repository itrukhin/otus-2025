<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
	"NAME" => Loc::GetMessage("NAME"),
	"DESCRIPTION" =>  Loc::GetMessage("DESCRIPTION"),
	"ICON" => "/images/news_list.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "otus",
		"CHILD" => array(
			"ID" => "currencies",
			"NAME" => Loc::GetMessage("NAME"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "views",
			),
		),
	),
);

?>