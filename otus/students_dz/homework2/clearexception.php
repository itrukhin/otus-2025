<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
// ТУТ ДОБАВИТЬ СВОЮ ФУНКЦИЮ ОЧИСТКИ ЛОГА
file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/local/logs/exceptions.log', '');
LocalRedirect('/otus/students_dz/homework2/');
