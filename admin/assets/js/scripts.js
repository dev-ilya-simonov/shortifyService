$(document).ready(function(){
    $('[data-ajax]').focus(function(e){
        $(this).prop('readonly',false);
    }).blur(function(e){
        $(this).prop('readonly',true);
    });

    $('input[data-ajax]').change(function(){
        var $row = $(this).closest('tr');
        var type = $(this).data('type');
        var data = 'type='+type+'&id='+$(this).data('id')+'&FIELD__'+$(this).attr('name')+'='+$(this).val();
        var url = '/admin/ajax/linkActions.php';
        $.ajax({
            method: "POST",
            url: url,
            data: data
        })
        .done(function(resp) {
            resp = JSON.parse(resp);
            alert(resp.MESSAGE);
        });
    })

    $('[data-type="delete"]').click(function(){
        var $row = $(this).closest('tr');
        var type = $(this).data('type');
        var data = 'type='+type+'&id='+$(this).data('id');
        var url = '/admin/ajax/linkActions.php';
        $.ajax({
            method: "POST",
            url: url,
            data: data
        })
        .done(function(resp) {
            console.log(resp);
            resp = JSON.parse(resp);
            if(resp.STATUS == 'OK')
                $row.remove();
            alert(resp.MESSAGE);
        });
    })

})