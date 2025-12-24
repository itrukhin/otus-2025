<?

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

$request = Application::getInstance()->getContext()->getRequest();

Loader::includeModule('iblock');

try {
    $doctorId = $request->get('id');

    $doctor = \App\Models\Lists\DoctorPropertyValuesTable::query()
        ->setSelect(['ID' => 'IBLOCK_ELEMENT_ID', 'NAME' => 'ELEMENT.NAME', 'PROCEDURES'])
        ->where('IBLOCK_ELEMENT_ID', $doctorId)
        ->exec()
        ->fetch();

    if (!$doctor || empty($doctor['PROCEDURES'])) {
        echo "Нет процедур.";
        return;
    }

    $procedures = \App\Models\Lists\ProcedurePropertyValuesTable::query()
        ->setSelect(['ID' => 'IBLOCK_ELEMENT_ID', 'NAME' => 'ELEMENT.NAME'])
        ->whereIn('IBLOCK_ELEMENT_ID', $doctor['PROCEDURES'])
        ->exec()
        ->fetchAll();

    ?>
    <h1><?= $doctor['NAME'] ?></h1>
    <strong>Процедуры:</strong>
    <ul>
        <? foreach ($procedures as $procedure) { ?>
            <li><?= $procedure['NAME'] ?></li>
        <? } ?>
    </ul>
    <a href="/otus/students_dz/homework3/">Назад</a>
    <?php

} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}


/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #3: Связывание моделей - " . $doctor['NAME']);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
