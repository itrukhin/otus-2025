<?php
// Подключаем UI библиотеки
\Bitrix\Main\UI\Extension::load(["main.ui.grid", "main.core"]);
/** @global \CMain $APPLICATION */
$APPLICATION->SetPageProperty('BodyClass', 'page--grid');
?>

<div id="otus-clinic-grid-container">
    <?php
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '',
        [
            'GRID_ID'   => $arResult['GRID_ID'],
            'COLUMNS'   => $arResult['COLUMNS'],
            'ROWS'      => $arResult['ROWS'],
            'NAV_OBJECT' => null,
            'AJAX_MODE' => 'N',
            'SHOW_CHECK_ALL_CHECKBOXES' => false,
            'SHOW_ROW_CHECKBOXES'       => false,
            'SHOW_ACTION_PANEL'         => false,
            'ALLOW_COLUMNS_SORT'        => true,
            'ALLOW_COLUMNS_RESIZE'      => true,
            'SHOW_PAGESIZE'             => false,
            'SHOW_SELECTED_COUNTER'     => false,
            'SHOW_TOTAL_COUNTER'        => false,
            'SHOW_PAGINATION'           => true,
        ]
    );
    ?>
</div>

<style>
    #otus-clinic-grid-container {
        margin: 20px;
    }
    .page--grid .main-page-content {
        padding: 0 !important;
    }
</style>