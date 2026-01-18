<?php
namespace App\Models\Orm;

use App\Models\Lists\DoctorPropertyValuesTable;
use App\Models\Lists\ProcedurePropertyValuesTable;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Query\Join;

class OtusClinicTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'otus_clinic';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),
            (new IntegerField('DEPARTMENT_ID'))
                ->configureRequired(),
            (new StringField('DEPARTMENT_NAME'))
                ->configureRequired()
                ->configureSize(100),
//            (new ReferenceField(
//                'DOCTOR',
//                DoctorPropertyValuesTable::class,
//                Join::on('this.DEPARTMENT_ID', 'ref.DEPARTMENT_ID')
//            ))->configureJoinType(Join::TYPE_LEFT),
            (new ReferenceField(
                'DOCTOR',
                \Bitrix\Iblock\Elements\ElementDoctorsTable::class,
                Join::on('this.DEPARTMENT_ID', 'ref.IBLOCK_SECTION_ID')
            ))->configureJoinType(Join::TYPE_LEFT),
            (new ReferenceField(
                'PROCEDURE',
                \Bitrix\Iblock\Elements\ElementProceduresTable::class,
                //ProcedurePropertyValuesTable::class,
                Join::on('this.DOCTOR.PROCEDURES.VALUE', 'ref.ID')
            ))->configureJoinType(Join::TYPE_LEFT),
        ];
    }
}