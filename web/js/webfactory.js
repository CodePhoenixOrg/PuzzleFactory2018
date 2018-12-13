var APP_NAME = "webfactory";
var wf = null;
var wfHost = 'webfactory.loc';
//var wfHost = (window.location.href.indexOf('localhost') > -1) ? 'localhost:8000' : 'wf.loc';
Phink.DOM.ready(function () {

    wf = Phink.Web.Application.create(wfHost);
    wf.main = wf.createView('main');

    var wfMain = wf.createController(wf.main, 'webfactory.main')
    .actions({
        goHome: function () {
            wfMain.getSimpleView('master.html', function (data) {
                $(document.body).html(data.view);
                wfMain.attachView('home.html', '#homeContent');
            });
        }
    })
    .onload(function () {
        wfMain = this;
        this.goHome();
    });
});
