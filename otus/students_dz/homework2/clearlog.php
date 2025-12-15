<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

// ТУТ ДОБАВИТЬ СВОЮ ФУНКЦИЮ ОЧИСТКИ ЛОГА
// unlink($_SERVER["DOCUMENT_ROOT"] . '/local/logs/log_custom.log');
\App\Debug\Log::cleanLog();

LocalRedirect('/otus/students_dz/homework2/');
