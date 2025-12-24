<?
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #3: Связывание моделей");

Asset::getInstance()->addCss('//cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

Loader::includeModule('iblock');

$elements = \Bitrix\Iblock\ElementTable::getList([
    'filter' => ['IBLOCK_ID' => 16],
])->fetchCollection();

//dump($elements);
?>
<style>
    .custom-link {
        margin: 20px;
    }
</style>
<ul>
    <? foreach ($elements as $element) { ?>
        <li>
            <a class="btn btn-secondary custom-link" href="/otus/students_dz/homework3/detail.php?id=<?=$element->getId()?>">
                <?=$element->getName()?>
            </a>
        </li>
    <? } ?>
</ul>
<a href="/services/lists/16/element/0/0/?list_section_id=">Добавить врача</a>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>