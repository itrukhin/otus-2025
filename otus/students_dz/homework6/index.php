<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #6: Разработка модуля для расширения стандартного модуля CRM");
?>
    <div class="container">
<?php
$APPLICATION->IncludeComponent(
        'otus:clinic.table',
        '.default',
        []
);
?>
    </div>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");