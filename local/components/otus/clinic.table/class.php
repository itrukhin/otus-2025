<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use App\Models\Orm\OtusClinicTable;
use Bitrix\Main\Engine\Contract\Controllerable;

class OtusClinicListComponent extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [];
    }

    public function executeComponent()
    {
        $this->arResult = [
            'GRID_ID' => 'OTUS_CLINIC_GRID',
            'ROWS'    => $this->loadData(),
            'COLUMNS' => $this->getColumns(),
        ];

        $this->includeComponentTemplate();
    }

    private function getColumns(): array
    {
        return [
            ['id' => 'ID',              'name' => 'ID',             'sort' => 'ID', 'default' => true],
            ['id' => 'DEPARTMENT_NAME', 'name' => 'Отделение',      'sort' => 'DEPARTMENT_NAME', 'default' => true],
            ['id' => 'DOCTOR_NAME',     'name' => 'Врач',           'default' => true],
            ['id' => 'PROCEDURES',      'name' => 'Процедуры',      'default' => true],
        ];
    }

    private function loadData(): array
    {
        $rows = [];
        $id = 0;

        \Bitrix\Main\Loader::includeModule('iblock');
        $query = OtusClinicTable::query()
            ->setSelect([
                'DEPARTMENT_NAME',
                'DOCTOR_NAME' => 'DOCTOR.NAME',
                'PROCEDURE_NAME' => 'DOCTOR.PROCEDURES.ELEMENT.NAME',
            ])
            ->whereNotNull('DOCTOR.ID')
            ->setOrder(['DEPARTMENT_NAME', 'DOCTOR_NAME']);

        $result = $query->exec();
        while ($row = $result->fetch()) {
            $rows[] = [
                'id' => ++$id,
                'data' => [
                    'ID' => $id,
                    'DEPARTMENT_NAME' => $row['DEPARTMENT_NAME'] ?: '—',
                    'DOCTOR_NAME' => $row['DOCTOR_NAME'] ?: '—',
                    'PROCEDURES' => $row['PROCEDURE_NAME'] ?: '—',
                ],
            ];
        }

        return $rows;
    }
}