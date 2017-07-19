$(document).ready(function() {
    var template = $('#content').data('page');
    var action = $('#content').data('action');
    switch (template) {
        case 'articles':
            var templateCtrl = new Article();
            break;
        default:
            var templateCtrl = new Dashboard();
            break;
    }

    switch (action) {
        case 'index':
            templateCtrl.index();
            break;
        case 'show':
            templateCtrl.show();
            break;
        case 'create':
            templateCtrl.create();
            break;
        case 'update':
            templateCtrl.update();
            break;
        case 'login':
            templateCtrl = new Dashboard();
            templateCtrl.login();
            break;
        case 'register':
            templateCtrl = new Dashboard();
            templateCtrl.register();
            break;
        default:
            templateCtrl.init();
            break;
    }

    $('.load-more').on('click', function(e) {
        e.preventDefault();
        alert('Looks like there was no time to implement this functionality ;(');
    });

    $('#logout').on('click', function(e) {
        e.preventDefault();

        $.deleteJSON('/api/session', [], function(res) {
            if (res.Status == 1) {
                window.location.href = '/login';
            }
        });
    });
});
