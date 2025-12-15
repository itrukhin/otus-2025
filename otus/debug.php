<?php
use Bitrix\Main\Diag\Debug;

/** @var \CMain $APPLICATION */
global $APPLICATION;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Тестирование логов");

$dateTime = new \Bitrix\Main\Type\DateTime();
dump("Запись в лог " . $dateTime);
Debug::writeToFile($dateTime);

///\App\Debug\Log::;

?>
<textarea style="width: 100%; height: 500px;">
<?=file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/__bx_log.log')?>
</textarea>
<?php

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
