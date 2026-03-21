<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #8: Модификация интерфейса на стороне клиента");

$resultMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_bitrix_sessid()) {
    if (!Loader::includeModule('timeman')) {
        $resultMessage = '<span style="color: red;">Ошибка: модуль "timeman" не подключен.</span>';
    } else {
        try {
            $connection = Application::getConnection();

            // Получаем максимальный ID из таблицы рабочих сессий
            $query = "SELECT MAX(ID) as MAX_ID FROM b_timeman_entries";
            $result = $connection->query($query);
            $row = $result->fetch();

            if (!$row || !$row['MAX_ID']) {
                $resultMessage = '<span style="color: red;">Нет записей для удаления в таблице b_timeman_entries.</span>';
            } else {
                $entryId = (int)$row['MAX_ID'];

                // Начинаем транзакцию
                $connection->startTransaction();

                // Удаляем связанные записи из зависимых таблиц
                $tablesToDelete = [
                    'b_timeman_absence',
                    'b_timeman_report_daily',
                    'b_timeman_reports'
                ];

                foreach ($tablesToDelete as $table) {
                    $sql = "DELETE FROM {$table} WHERE ENTRY_ID = {$entryId}";
                    $connection->queryExecute($sql);
                }

                // Удаляем саму запись из b_timeman_entries
                $sql = "DELETE FROM b_timeman_entries WHERE ID = {$entryId}";
                $connection->queryExecute($sql);

                // Фиксируем транзакцию
                $connection->commitTransaction();

                $resultMessage = "<span style='color: green;'>Запись с ID={$entryId} успешно удалена.</span>";
            }
        } catch (Exception $e) {
            $connection->rollbackTransaction();
            $resultMessage = '<span style="color: red;">Ошибка при удалении: ' . htmlspecialcharsbx($e->getMessage()) . '</span>';
        }
    }
}
?>

    <form method="post">
        <?=bitrix_sessid_post()?>
        <button type="submit">Удалить рабочий день</button>
    </form>

<?php if ($resultMessage): ?>
    <div id="result"><?=$resultMessage?></div>
<?php endif; ?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");