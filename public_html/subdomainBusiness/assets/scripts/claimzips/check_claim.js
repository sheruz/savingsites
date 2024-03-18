$(document).ready(function () {
    $('table').dataTable(
                {
                    "sDom": 't<"admin-footer-container"i>',
                    "iDisplayLength": -1
                });

});

function setAllCheck(flag) {
    if (flag == 0) {
        $("INPUT[type='checkbox']").attr('checked', false);
    }
    else {
        $("INPUT[type='checkbox']").attr('checked', true);
    }
}
