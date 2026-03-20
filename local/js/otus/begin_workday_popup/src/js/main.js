BX.namespace('Otus.BeginWorkdayPopup');

BX.Otus.BeginWorkdayPopup = {
    showMessage: function ($message) {
        alert($message);
    },
    onStartWorkingDateAction: function (popupNodeId) {
        var popup = BX.PopupWindowManager.create("greeting-popup", BX(popupNodeId), {
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
                    text: "Да",
                    id: "btn_yes",
                    className: "ui-btn ui-btn-success",
                    events: {
                        click: function () {
                            BX.Otus.BeginWorkdayPopup.startDate();
                        }
                    }
                }),
                new BX.PopupWindowButton({
                    text: "Нет",
                    id: "btn_no",
                    className: "ui-btn ui-btn-success",
                    events: {
                        click: function () {
                            popup.close();
                        }
                    }
                })
            ],
            events: {
                onPopupClose: function () {
                    BX.Otus.BeginWorkdayPopup.showMessage('Закрыто');
                },
                onPopupShow: function () {
                    BX.Otus.BeginWorkdayPopup.showMessage('Открыто');
                }
            }

        }).show();
    },
    startDate: function () {
        BX.ajax.runComponentAction('otus:begin-workday-popup', 'startWorkday', {
            data: {}
        });
    }
};

BX.addCustomEvent('onTimeManWindowBuild', function (event) {
    console.log(event);
    alert('onTimeManWindowBuild');
});
BX.addCustomEvent('onTMClockRegister', function (event) {
    console.log(event);
    alert('onTMClockRegister');
    // Удаляем все элементы с ID, начинающимся на "timeman_time_selector_popup"
    document.querySelectorAll('[id^="timeman_time_selector_popup"]').forEach(function (element) {
        element.remove();
    });
    // Удаляем все элементы с ID, начинающимся на "timeman_edit_popup_"
    document.querySelectorAll('[id^="timeman_edit_popup_"]').forEach(function (element) {
        element.remove();
    });
});


