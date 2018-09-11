//console.log('dashboard.js');
$(document).ready(function() {
    $('#cb-switch-licence').change(function() {
        if ($(this).prop('checked')) {
            $("#activate-licence").submit();
        } else {
            $("#deactivate-licence").submit();
        }
    });
    
    $('#cb-switch-suspend').change(function() {
        if ($(this).prop('checked')) {
            let obj = this;
            $("button[data-dismiss='modal']").click(function() {
                $(obj).prop('checked', false);
            });
        } else {
            $("#activate").submit();
        }
    });
    
    $('#cb-switch-renew').change(function() {
        if ($(this).prop('checked')) {
            $("#auto-renew").submit();
        } else {
            $("#cancel-auto-renew").submit();
        }
    });
});

$('#datepicker').datepicker({
    altField: "#start-date",
    altFormat: "yy/mm/dd",
    dateFormat: "dd/mm/yy"
});