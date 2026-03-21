BX.namespace('Otus.BeginWorkdayPopup');

BX.Otus.BeginWorkdayPopup = {
    showMessage: function ($message) {
        alert($message);
    },
    onStartWorkingDateAction: function (popupNodeId, state) {
        let popup = BX.PopupWindowManager.create("greeting-popup", BX(popupNodeId), {
            content: 'Вы хотите начать рабочий день?',
            width: 600,
            height: 400,
            zIndex: 100,
            offsetTop: 0,
            offsetLeft: 600,
            closeIcon: {
                opacity: 1
            },
            titleBar: "Начать рабочий день",
            closeByEsc: true,
            darkMode: false,
            autoHide: true,
            draggable: true,
            resizeable: true,
            min_height: 100,
            min_width: 100,
            lightShadow: true,
            angle: true,
            overlay: {
                backgroundColor: 'black',
                opacity: 500
            },
            buttons: [
                new BX.PopupWindowButton({
                    text: "Начать",
                    id: "btn_start",
                    className: "ui-btn ui-btn-success" + (state === 'OPENED' || state === 'PAUSED' ? ' ui-btn-disabled' : ''),
                    events: {
                        click: function () {
                            BX.ajax.runAction('otus:demo.controllers.TimemanController.startWork').then(
                                function(response) {
                                    if (response.data.status === 'success') {
                                        console.log('Успех:', response.data);
                                        alert(response.data.message);
                                    } else {
                                        alert('Ошибка: ' + response.data.message);
                                    }
                                }
                            );
                            this.popupWindow.close();
                        }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Остановить",
                    id: "btn_stop",
                    className: "ui-btn ui-btn-danger" + (state === 'CLOSED' ? ' ui-btn-disabled' : ''),
                    events: {
                        click: function () {
                            BX.ajax.runAction('otus:demo.controllers.TimemanController.stopWork').then(
                                function(response) {
                                    if (response.data.status === 'success') {
                                        console.log('Успех:', response.data);
                                        alert(response.data.message);
                                    } else {
                                        alert('Ошибка: ' + response.data.message);
                                    }
                                }
                            );
                            this.popupWindow.close();
                        }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Пауза",
                    id: "btn_pause",
                    className: "ui-btn ui-btn-warning" + (state === 'PAUSED' || state === 'CLOSED' ? ' ui-btn-disabled' : ''),
                    events: {
                        click: function () {
                            BX.ajax.runAction('otus:demo.controllers.TimemanController.pauseWork').then(
                                function(response) {
                                    if (response.data.status === 'success') {
                                        console.log('Успех:', response.data);
                                        alert(response.data.message);
                                    } else {
                                        alert('Ошибка: ' + response.data.message);
                                    }
                                }
                            );
                            this.popupWindow.close();
                        }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Возобновить",
                    id: "btn_restart",
                    className: "ui-btn ui-btn-success" + (state === 'OPENED' ? ' ui-btn-disabled' : ''),
                    events: {
                        click: function () {
                            BX.ajax.runAction('otus:demo.controllers.TimemanController.restartWork').then(
                                function(response) {
                                    if (response.data.status === 'success') {
                                        console.log('Успех:', response.data);
                                        alert(response.data.message);
                                    } else {
                                        alert('Ошибка: ' + response.data.message);
                                    }
                                }
                            );
                            this.popupWindow.close();
                        }
                    }
                })
            ]
            // ,
            // events: {
            //     onPopupClose: function () {
            //         BX.Otus.BeginWorkdayPopup.showMessage('Закрыто');
            //     },
            //     onPopupShow: function () {
            //         BX.Otus.BeginWorkdayPopup.showMessage('Открыто');
            //     }
            // }

        }).show();
    }
};

BX.addCustomEvent('onTimeManWindowBuild', function (event) {
    console.log(event);
    /*
    "STATE:CLOSED|CAN_OPEN:REOPEN|CAN_EDIT:Y/DATE_START:1774086573|DATE_FINISH:1774087036|TIME_LEAKS:134"
     */
    let mainRowState = event.MAIN_ROW_STATE;
    // Разделяем строку по символу "|" и ищем часть, начинающуюся с "STATE:"
    let state = null;
    mainRowState.split('|').forEach(function (part) {
        if (part.startsWith('STATE:')) {
            state = part.substring(6); // Убираем "STATE:" и получаем значение
        }
    });

    // Теперь state содержит нужное значение, например: "CLOSED"
    // OPENED | CLOSED | PAUSED
    alert('Состояние: ' + state);

    //Удаляем окно с ИД timeman_main
    if (BX('timeman_main')) {
        BX('timeman_main').remove();
    }

    BX.Otus.BeginWorkdayPopup.onStartWorkingDateAction('', state);

    //alert('onTimeManWindowBuild');
});
BX.addCustomEvent('onTMClockRegister', function (event) {
    console.log(event);
    alert('Ручное редактирование рабочего дня запрещено!');
    // Удаляем все элементы с ID, начинающимся на "timeman_time_selector_popup"
    document.querySelectorAll('[id^="timeman_time_selector_popup"]').forEach(function (element) {
        element.remove();
    });
    // Удаляем все элементы с ID, начинающимся на "timeman_edit_popup_"
    document.querySelectorAll('[id^="timeman_edit_popup_"]').forEach(function (element) {
        element.remove();
    });
});


