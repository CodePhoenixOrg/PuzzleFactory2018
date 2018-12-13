//wf.home = wf.createView('home');
var wfHome = wf.createController(wf.main, 'webfactory.home')
.actions({
    goPage: function () {
        wfHome.attachView('page.html', '#homeContent');
        /*
        wfHome.getSimpleView('page.html', function (data) {
            $(document.body).html(data.view);
        });
        */
    }
})
.onload(function () {
    wfHome = this;
    $('#logo').on('click', wfHome.goPage());
});
