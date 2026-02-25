<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
/** @var \CMain $APPLICATION */
$APPLICATION->SetTitle("ДЗ #7: Создать свой тип поля для элементов инфоблока");
?>
    <div class="container">
        <a href="#" id="recordPatient">Записать пациента</a>
    </div>

    <script>
        BX.ready(function() {
            BX.bind(BX('recordPatient'), 'click', function(e) {
                e.preventDefault();
                
                var dialog = new BX.PopupWindow('record_patient_dialog', this, {
                    autoHide: true,
                    offsetLeft: 0,
                    offsetTop: 0,
                    overlay : true,
                    draggable: {restrict: false},
                    title: 'Запись пациента',
                    closeByEsc: true,
                    content: '\n' +
                        '    <form id="recordPatientForm">\n' +
                        '        <div class="form-row">\n' +
                        '            <label for="patientName">Имя пациента:</label>\n' +
                        '            <input type="text" id="patientName" name="patientName" required>\n' +
                        '        </div>\n' +
                        '        <div class="form-row">\n' +
                        '            <label for="appointmentTime">Время записи:</label>\n' +
                        '            <input type="datetime-local" id="appointmentTime" name="appointmentTime" required>\n' +
                        '        </div>\n' +
                        '    </form>\n',
                    buttons: [
                        new BX.PopupWindowButton({
                            text: 'Записать',
                            className: 'ui-btn ui-btn-primary',
                            events: {
                                click: function() {
                                    var form = BX('recordPatientForm');
                                    var patientNameInput = BX('patientName');
                                    var appointmentTimeInput = BX('appointmentTime');
                                    
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
                                            appointmentTime: appointmentTime
                                        }
                                    }).then(function(response) {
                                        alert(response.data.message);
                                        dialog.close();
                                    }).catch(function(response) {
                                        alert('Ошибка при записи пациента');
                                    });
                                }
                            }
                        }),
                        new BX.PopupWindowButton({
                            text: 'Отменить',
                            className: 'ui-btn ui-btn-light-border',
                            events: {
                                click: function() {
                                    dialog.close();
                                }
                            }
                        })
                    ]
                });
                
                dialog.show();
            });
        });
    </script>
<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");