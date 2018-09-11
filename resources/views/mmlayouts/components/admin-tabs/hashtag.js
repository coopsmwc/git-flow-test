window.addEventListener("load", function(event) {
    var query = location.href.split('#');
    if (query.length > 1) {
        var tabs = document.getElementById('admintabs').getElementsByClassName('nav-link');
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].classList.remove('active'); tabs[i].classList.remove('show');
            if (tabs[i].id === query[1]+'-tab') {
                tabs[i].classList.add('active'); tabs[i].classList.add('show');
            }
        }
        var content = document.getElementById('admintabsContent').getElementsByClassName('tab-pane');
        for (var i = 0; i < content.length; i++) {
            content[i].classList.remove('active'); content[i].classList.remove('show');
            if (content[i].id === query[1]) {
                content[i].classList.add('active'); content[i].classList.add('show');
            }
        }
        
    }
    if (document.getElementById('tabs-container')) {
        document.getElementById('tabs-container').classList.remove('d-none');
    }
    
    $('#admintabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        window.location.hash = e.currentTarget.hash;
    });
});
