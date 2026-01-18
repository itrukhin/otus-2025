<?php
namespace App\Models\Lists;

use App\Models\AbstractIblockPropertyValuesTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Query\Join;

/*
 * Свойства:
 * PROCEDURES - список процедур ProcedurePropertyValuesTable
 * DEPARTMENT_ID - отделение integer
 */
class DoctorPropertyValuesTable extends AbstractIblockPropertyValuesTable
{
    public const IBLOCK_ID = 16;

//    public static function getMap(): array
//    {
//        $map = [
//            'PROCEDURE_LIST' => (new ReferenceField(
//                'PROCEDURE_LIST',
//                ProcedurePropertyValuesTable::class,
//                Join::on('this.PROCEDURES', 'ref.IBLOCK_ELEMENT_ID')
//            ))->configureJoinType(Join::TYPE_LEFT),
//        ];
//
//        return parent::getMap() + $map;
//    }
}