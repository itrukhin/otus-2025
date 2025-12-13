<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// ТУТ ДОБАВИТЬ СВОЮ ФУНКЦИЮ ОЧИСТКИ ЛОГА
// unlink($_SERVER["DOCUMENT_ROOT"] . '/local/logs/log_custom.log');
file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/local/logs/log_custom.log', '');
LocalRedirect('/otus/students_dz/homework2/');
