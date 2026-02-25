<?php
namespace Otus\Demo\UserTypes;

use Bitrix\Main\Localization\Loc;

class AppointmentType extends \CIBlockPropertyElementList
{
    public const USER_TYPE = 'AppointmentType';

    public static function GetUserTypeDescription() {

        $description = parent::GetUserTypeDescription();
        $description['USER_TYPE'] = self::USER_TYPE;
        $description['DESCRIPTION'] = Loc::getMessage('OTUS_APPOINTMENT_TYPE');
        $description['GetPublicViewHTML'] = [__CLASS__,  'GetPublicViewHTML'];
        return $description;
    }

    public static function GetPublicViewHTML($arProperty, $arValue, $strHTMLControlName)
    {
        static $cache = array();

        $strResult = '';
        $arValue['VALUE'] = intval($arValue['VALUE']);
        if (0 < $arValue['VALUE'])
        {
            $viewMode = '';
            $resultKey = '';
            if (!empty($strHTMLControlName['MODE']))
            {
                switch ($strHTMLControlName['MODE'])
                {
                    case 'CSV_EXPORT':
                        $viewMode = 'CSV_EXPORT';
                        $resultKey = 'ID';
                        break;
                    case 'EXTERNAL_ID':
                        $viewMode = 'EXTERNAL_ID';
                        $resultKey = '~XML_ID';
                        break;
                    case 'SIMPLE_TEXT':
                        $viewMode = 'SIMPLE_TEXT';
                        $resultKey = '~NAME';
                        break;
                    case 'ELEMENT_TEMPLATE':
                        $viewMode = 'ELEMENT_TEMPLATE';
                        $resultKey = '~NAME';
                        break;
                    case 'BIZPROC':
                        $viewMode = 'BIZPROC';
                        break;
                }
            }

            if (!isset($cache[$arValue['VALUE']]))
            {
                $arFilter = [];
                $intIBlockID = (int)$arProperty['LINK_IBLOCK_ID'];
                if ($intIBlockID > 0)
                    $arFilter['IBLOCK_ID'] = $intIBlockID;
                $arFilter['ID'] = $arValue['VALUE'];
                if ($viewMode === '')
                {
                    $arFilter['ACTIVE'] = 'Y';
                    $arFilter['ACTIVE_DATE'] = 'Y';
                    $arFilter['CHECK_PERMISSIONS'] = 'Y';
                    $arFilter['MIN_PERMISSION'] = 'R';
                }
                $rsElements = \CIBlockElement::GetList(
                    array(),
                    $arFilter,
                    false,
                    false,
                    array("ID","IBLOCK_ID","NAME","DETAIL_PAGE_URL")
                );
                if (isset($strHTMLControlName['DETAIL_URL']))
                {
                    $rsElements->SetUrlTemplates($strHTMLControlName['DETAIL_URL']);
                }
                $cache[$arValue['VALUE']] = $rsElements->GetNext(true, true);
                unset($rsElements);
            }
            if (!empty($cache[$arValue['VALUE']]) && is_array($cache[$arValue['VALUE']]))
            {
                if ($viewMode !== '' && $resultKey !== '')
                {
                    $strResult = $cache[$arValue['VALUE']][$resultKey];
                }
                else
                {
                    $strResult = self::renderItemHtml($cache[$arValue['VALUE']]);
                    //$strResult = '<a href="'.$cache[$arValue['VALUE']]['DETAIL_PAGE_URL'].'">'.$cache[$arValue['VALUE']]['NAME'].' - 111</a>';
                }
            }
        }
        return $strResult;
    }

    private static function renderItemHtml($item)
    {
        //\Bitrix\Main\Diag\Debug::dumpToFile(print_r($item, true));
        $formHtml = <<<FORM
<form id="recordPatientForm_##ID##">
	<div class="form-row">
		<label for="patientName_##ID##">Имя пациента:</label>
		<input type="text" id="patientName_##ID##" name="patientName" required>
	</div>
	<div class="form-row">
		<label for="appointmentTime_##ID##">Время записи:</label>
        <input type="datetime-local" id="appointmentTime_##ID##" name="appointmentTime" required>
<!--		<input type="text" id="appointmentTime_##ID##" name="appointmentTime" required  onclick="BX.calendar({node: this, field: this, bTime: true});">-->
	</div>
</form>
FORM;
        $formHtml = str_replace('##ID##', $item['ID'], $formHtml);
        $formHtml = str_replace(["\n", "\r"], '', $formHtml);

        $htmlTemplate = <<<HTML
    <div class="container">
        <a href="#" id="recordPatient_##ID##">Записать на ##NAME##</a>
    </div>

        <script>
        BX.ready(function() {
            var dialog_##ID## = null;

            BX.bind(BX('recordPatient_##ID##'), 'click', function(e) {
                e.preventDefault();

                // Уничтожаем старый диалог, если был
                if (dialog_##ID##) {
                    dialog_##ID##.destroy();
                }

                // Создаём новый диалог каждый раз
                dialog_##ID## = new BX.PopupWindow('record_patient_dialog_##ID##', this, {
                    autoHide: true,
                    overlay: true,
                    draggable: false,
                    title: 'Запись пациента',
                    closeByEsc: true,
                    content: '<div id="dialog-content-##ID##">##FORM##</div>',
                    onFirstShow: function() {
                        // Очищаем поля при первом показе
                        var patientNameInput = BX('patientName_##ID##');
                        var appointmentTimeInput = BX('appointmentTime_##ID##');
                        
                        if (patientNameInput) patientNameInput.value = '';
                        if (appointmentTimeInput) appointmentTimeInput.value = '';
                    },
                    onClose: function() {
                        // Уничтожаем диалог при закрытии
                        dialog_##ID##.destroy();
                    },
                    buttons: [
                        new BX.PopupWindowButton({
                            text: 'Записать',
                            className: 'ui-btn ui-btn-primary',
                            events: {
                                click: function() {
                                    var patientNameInput = BX('patientName_##ID##');
                                    var appointmentTimeInput = BX('appointmentTime_##ID##');
                                    
                                    if (!patientNameInput || !appointmentTimeInput) {
                                        alert('Элементы формы не найдены');
                                        return;
                                    }
                                    
                                    var patientName = patientNameInput.value.trim();
                                    var appointmentTime = appointmentTimeInput.value;
                                    
                                    if (!patientName) {
                                        alert('Введите имя пациента');
                                        patientNameInput.focus();
                                        return;
                                    }
                                    
                                    if (!appointmentTime) {
                                        alert('Выберите дату и время записи');
                                        appointmentTimeInput.focus();
                                        return;
                                    }
                                    
                                    BX.ajax.runAction('otus:demo.controllers.AppointmentController.saveAppointment', {
                                        data: {
                                            patientName: patientName,
                                            appointmentTime: appointmentTime,
                                            procedureId: ##ID##
                                        }
                                    }).then(function(response) {
                                        alert(response.data.message);
                                        dialog_##ID##.close();
                                    }).catch(function(response) {
                                        var errorMessage = 'Ошибка при записи пациента';
                                        if (response && response.errors && response.errors.length > 0) {
                                            errorMessage = response.errors[0].message || errorMessage;
                                        }
                                        alert(errorMessage);
                                    });
                                }
                            }
                        }),
                        new BX.PopupWindowButtonLink({
                            text: 'Отменить',
                            className: 'ui-btn ui-btn-light-border',
                            events: {
                                click: function() {
                                    dialog_##ID##.close();
                                }
                            }
                        })
                    ]
                });

                dialog_##ID##.show();
            });
        });
    </script>
HTML;
        $html = str_replace('##ID##', $item['ID'], $htmlTemplate);
        $html = str_replace('##NAME##', $item['NAME'], $html);
        $html = str_replace('##FORM##', $formHtml, $html);
        return $html;
    }
}