<?php

namespace Otus\Demo\Controllers;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

class AppointmentController extends Controller
{
    public function configureActions(): array
    {
        return [
            'saveAppointment' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\Csrf(),
                    new ActionFilter\HttpMethod(
                        [ActionFilter\HttpMethod::METHOD_POST]
                    ),
                ],
            ],
        ];
    }

    public function saveAppointmentAction(string $patientName, string $appointmentTime, int $procedureId): array
    {
        // Валидация входных данных
        if (empty($patientName)) {
            return [
                'success' => false,
                'message' => 'Имя пациента не может быть пустым'
            ];
        }

        if (empty($appointmentTime)) {
            return [
                'success' => false,
                'message' => 'Время записи не может быть пустым'
            ];
        }

        if ($procedureId <= 0) {
            return [
                'success' => false,
                'message' => 'Не указан ID процедуры'
            ];
        }

        try {
            Loader::includeModule('iblock');

            $dateTime = new DateTime($appointmentTime, "Y-m-d\TH:i:s");
            $name = sprintf("%s (%s) - [%d]", $patientName, $appointmentTime, $procedureId);
            $fields = [
                'IBLOCK_ID' => 18, // ID инфоблока с записями на процедуры'
                'NAME' => $name,
                'ACTIVE_FROM' => $dateTime,
                'PROPERTY_VALUES' => [
                    'PROCEDURE' => $procedureId,
                    'APPOINTMENT_TIME' => $dateTime,
                    'PATIENT' => $patientName,
                ],
            ];
            Debug::dumpToFile(print_r($fields, true));
            $ib = new \CIBlockElement();
            $id = $ib->Add($fields);
            if(!$id) {
                Debug::dumpToFile($ib->LAST_ERROR);
                return [
                    'success' => false,
                    'message' => 'Ошибка при записи пациента: ' . $ib->LAST_ERROR
                ];
            }

            return [
                'success' => true,
                'patientName' => $patientName,
                'appointmentTime' => $appointmentTime,
                'procedureId' => $procedureId,
                'message' => 'Пациент успешно записан'
            ];
            
        } catch (\Exception $e) {
            Debug::dumpToFile($e);
            return [
                'success' => false,
                'message' => 'Ошибка при записи пациента: ' . $e->getMessage()
            ];
        }
    }
}
