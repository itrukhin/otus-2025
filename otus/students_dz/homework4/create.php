<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #4: Создание своих таблиц БД и написание модели данных к ним");

$entity = \App\Models\Orm\OtusClinicTable::class;
// Попытка соединение с таблицей ORM сущности
$entityTableConnection = \Bitrix\Main\Application::getConnection($entity::getConnectionName());
if (!$entityTableConnection->isTableExists($entity::getTableName())) {
    $entityInstance = \Bitrix\Main\Entity\Base::getInstance($entity);
    $entityInstance->createDbTable();
    echo "Таблица успешно создана";

} else {
//    $conn = \Bitrix\Main\Application::getConnection();
//    $conn->queryExecute("INSERT INTO otus_clinic (DEPARTMENT_ID, DEPARTMENT_NAME) VALUES (17, 'Терапевтическое отделение')");
//    $conn->queryExecute("INSERT INTO otus_clinic (DEPARTMENT_ID, DEPARTMENT_NAME) VALUES (18, 'Стоматологическое отделение')");
    echo "Таблица уже создана";
}

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
