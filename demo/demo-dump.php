<?php
/** @var \CMain $APPLICATION */
global $APPLICATION;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Демо дамп");

dump($_SERVER);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');