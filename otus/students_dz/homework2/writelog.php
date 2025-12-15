<?
use Bitrix\Main\Diag\Debug;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php"); ?>
<?php
/** @var CMain $APPLICATION */
$APPLICATION->SetTitle("Добавление в лог");
?>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="/local/logs/log_custom.log">Файл лога</a>,
            в лог добавленно 'Открыта страница writelog.php'
        </li>
    </ul>
<?
// ТУТ ДОБАВИТЬ СВОЮ ФУНКЦИЮ ДОБАВЛЕНИЯ В ЛОГ
\App\Debug\Log::addLog('Open page writelog.php');
?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>