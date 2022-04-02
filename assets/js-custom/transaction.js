function OnTransactionClick(elem) {
    $.get($(elem).data('route'), function (data) {
        $('#DV000').empty();
        $('#DV000').append(data);
        $('#DV000').addClass('show');
    })
}

function OnTransactionSubmit(frm) {
    busy = $(frm).data("busy");
    $(busy).addClass('overlay-show');
    $.post($(frm).attr('action'), $(frm).serialize(), function(data) {
        if (data.success) {
            toastr.success(data.message);
            setTimeout(function () {
                window.location.reload(true);
            }, 2000);
        }else{
            toastr.error(data.message);
            $(busy).removeClass('overlay-show');
        }
    });
    return false;
}

function OnCloseClick() {
    $('#DV000').empty();
    $('#DV000').removeClass("show");
}