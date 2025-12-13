<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Ошибка для exeption");
?>
<ul class="list-group">
    <li class="list-group-item">
        <a href="/local/logs/<?=date('Y-m-d')?>.log">Файл лога</a>
    </li>
</ul>
<?
// ошибка для exeption
throw new Exception("Тест исключения");
?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
