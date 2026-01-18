<?php

use App\Models\Orm\OtusClinicTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #4: Создание своих таблиц БД и написание модели данных к ним");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
Loader::includeModule('iblock');

/*
 * Создана таблица otus_clinic - отделения больницы
 * https://cj328233.tw1.ru/bitrix/admin/perfmon_table.php?lang=ru&table_name=otus_clinic
 * создание таблицы otus/students_dz/homework4/create.php
 *
 * модель local/App/Models/Orm/OtusClinicTable.php
 * связь с инфобоками реализована через псевдоклассы ElementXXXXXTable
 *
 * В инфоблоке Врачи создано два раздела - врачи разделены по отделениям больницы
 * https://cj328233.tw1.ru/bitrix/admin/iblock_list_admin.php?IBLOCK_ID=16&type=lists&lang=ru&find_section_section=0&SECTION_ID=0&apply_filter=Y
 */

/*
 * Выбираем всех врачей по отделениям, вместе с процедурами
 */
$connection = Bitrix\Main\Application::getConnection();
$tracker = $connection->startTracker();
$rows = OtusClinicTable::getList([
    'select' => ['*', 'DOCTOR', 'DOCTOR.PROCEDURES', 'PROCEDURE']
])->fetchAll();
$connection->stopTracker();

dump($rows);

echo '<pre>';
foreach ($tracker->getQueries() as $query) {
    // текст запроса
    var_dump($query->getSql());
    echo '<br><br>';
}
echo '</pre>';

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");