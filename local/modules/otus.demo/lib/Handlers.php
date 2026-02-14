<?php

namespace Otus\Demo;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Config\Option;

class Handlers
{
    public const MID = 'otus.demo';
    public static function updateTabs(Event $event): EventResult
    {
        $tabs = $event->getParameter('tabs');
        //Debug::dumpToFile($tabs);
        $isModuleActive = Option::get(self::MID, 'ACTIVE', 'N');
        $isModuleActive = $isModuleActive === 'Y';
        $availableEntityTypeIds = explode(
            ',',
            Option::get(self::MID, 'TAB_DISPLAY_CRM_ENTITY_TYPE_ID', '2'),
        );

        $entityTypeId = $event->getParameter('entityTypeID');

        if (
            $isModuleActive &&
            in_array($entityTypeId, $availableEntityTypeIds)
        ) {
            $tabs[] = [
                'id' => 'clinic_table',
                'name' => 'Врачи клиники',
                'loader' => [
                    'serviceUrl' => sprintf(
                        '/local/components/otus/clinic.table/lazyload.ajax.php?site=%s&%s',
                        SITE_ID,
                        \bitrix_sessid_get(),
                    ),
                    'componentData' => [
                        'params' => [

                        ],
                        'template' => '.default',
                    ],
                ],
            ];
        }

        return new EventResult(EventResult::SUCCESS, ['tabs' => $tabs]);
    }
}
