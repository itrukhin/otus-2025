<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var CMain $APPLICATION */
$APPLICATION->SetTitle("Ошибка для exeption");
?>
<ul class="list-group">
    <li class="list-group-item">
        <a href="/local/logs/exceptions.log">Файл лога</a>
    </li>
</ul>
<?
$debug = new App\Debug();
$debug->test();
// ошибка для exeption
throw new Exception("Test exeption");
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
