<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #5: Компонент списка таблицы БД");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
Loader::includeModule('iblock');
?>
    <div class="container">
<?php
$APPLICATION->IncludeComponent(
	"otus:currencies", 
	".default", 
	array(
		"CURRENCY" => "USD",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);
?>
    </div>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");