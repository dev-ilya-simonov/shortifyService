function isValidUrl(url) {
    var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi
    var regexp = new RegExp(expression);
    return regexp.test(url);
}

$(document).ready(function(){
    $('form').submit(function(e){
        e.preventDefault();
        
        var $form = $(this);
        var data = $form.serializeArray();
        var url = $form.attr('action');
        console.log(data);
        //if(isValidUrl(data[0].value)) {
            $.ajax({
                method: "POST",
                url: url,
                data: data
            })
            .done(function(resp) {
                console.log(resp);
                resp = JSON.parse(resp);
                if(resp.STATUS != 'ERROR') {
                    $form.append('<a href="'+resp.MESSAGE+'" target="_blank">'+resp.MESSAGE+'</a>')
                }
            });
        //} else alert('Вы ввели не правильный url');
    })

})