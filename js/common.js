window.App || ( window.App = {} );

App.hTimer = 0;
App.time_ms = 7000;

App.init = function() {

    if (App.hTimer) clearTimeout(App.hTimer);
    App.run();
};

App.run = function() {

    $.ajax({
        type: "POST",
        url: App.api_path + "/account.getSettings",
        data: "accountId=" + account.id + "&accessToken=" + account.accessToken + "&lastNotifyView=" + account.lastNotifyView,
        dataType: 'json',
        timeout: 30000,
        success: function(response) {

            //alert(response.messagesCount);

            if (response.hasOwnProperty('error')) {

                if (!response.error) {

                    if (response.hasOwnProperty('messagesCount')) {

                        if (response.messagesCount != 0) {

                            $('span.messages-badge').removeClass('hidden');
                            $('span.messages-primary-badge').removeClass('hidden').text(response.messagesCount);

                        } else {

                            $('span.messages-badge').addClass('hidden');
                            $('span.messages-primary-badge').addClass('hidden').text(0);
                        }
                    }

                    if (response.hasOwnProperty('notificationsCount')) {

                        if (response.notificationsCount != 0) {

                            $('span.notifications-badge').removeClass('hidden');
                            $('span.notifications-primary-badge').removeClass('hidden').text(response.notificationsCount);

                        } else {

                            $('span.notifications-badge').addClass('hidden');
                            $('span.notifications-primary-badge').addClass('hidden').text(0);
                        }
                    }
                }
            }
        },
        complete: function() {

            // console.log(update.time_ms)
            // Добавляем 4 секунд для следуещего обновления
            App.time_ms = App.time_ms + 4000;

            App.hTimer = setTimeout(function() {

                App.init();

            }, App.time_ms);
        }
    });
};