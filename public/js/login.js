
$(document).ready(function(){
    $('.anchor-div a').bind('click',function(e) {
        var url = $('#application_url_login').val();

        $.ajax({
            url: url + "/bitsemailauthenticate",
            dataType: "json",
            success: function (data) {
                alert(1);
            }
        });
    })

});    