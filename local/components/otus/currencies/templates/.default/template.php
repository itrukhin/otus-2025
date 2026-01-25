<?
use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="alert alert-warning">
    <?= Loc::getMessage('CURRENCY')?>
    <?= ($arResult['AMOUNT_CNT'] > 1 ? $arResult['AMOUNT_CNT'] : '')?>
    <?= $arResult['CURRENCY']?>
    =
    <?= $arResult['RATE']?>
    <!-- вывести символ рубля -->
    <span class="rubl">₽</span>
</div>

