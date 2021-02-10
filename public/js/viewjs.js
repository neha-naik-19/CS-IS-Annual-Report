
/******************************************/

$(document).ready(function()
{
    $('.date-own').datepicker({
        minViewMode: 2,
        format: 'yyyy'
      });

    function alertbox_view(title, msg, $true) {
        var $content =  "<div class='dialog-ovelay'>" +
                        "<div class='dialog'><header>" +
                        " <h3> " + title + " </h3> " +
                        "<i class='fa fa-close'></i>" +
                            "</header>" +
                            "<div class='dialog-msg'>" +
                                " <p> " + msg + " </p> " +
                            "</div>" +
                            "<footer>" +
                                "<div class='controls' style='display: flex; justify-content: center; align-items: center;'>" +
                                    " <button class='button button-danger doAction'>" + $true + "</button> " +
                                "</div>" +
                            "</footer>" +
                        "</div>" +
                        "</div>";
        $('body').prepend($content);

        $('.doAction').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
                // $('#viewdatefldfrom').focus();
            });
        });
    }

    $('.hide-div').focus(function() {
        $("#div_view_author_search").addClass("hidetd");
        $("#auth-view-data > tbody > tr").empty();
    });

    $('#author_view_search').keyup(function() {
        var query = $(this).val();
        
        if(query != '')
        {
          fetch_view_author_data(query);
        }
        else
        {
          $("#div_view_author_search").addClass("hidetd");
          $("#auth-view-data > tbody > tr").empty();
        }
    });

    function fetch_view_author_data(query = ''){
        if(query != '')
        {
            var url = $('#application_url').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'json',
                url: url + '/viewsearch',
                contentType:"application/json; charset=utf-8",
                data:{query:query},
                success:function(data)
                {
                    if(data.length == 0)
                    {
                        $("#div_view_author_search").addClass("hidetd");
                        $('#auth-view-data tbody').html('');
                    }
                    else
                    {
                        $('#auth-view-data tbody').html('');
                        if(data.table_data == undefined)
                        {
                            $("#div_view_author_search").addClass("hidetd");
                        }
                        else
                        {
                            $('#auth-view-data tbody').html(data.table_data);
                        }
                        
                        $("#dynamic_view_content").css({"height": "100%", "width": "100%","overflow": "auto","overflow-x": "hidden"});
                        $("#div_view_author_search").removeClass("hidetd");
                    }
                },
                error:function(xhr, errorType, exception)
                {
                    console.log(xhr.responseText)
                    console.log('errorType : ' + errorType + " exception : " + exception)
                }
            });
        }
    }

    $('#auth-view-data').on('click', 'tr', function(e)
    {
        $('#author_view_search').val($(this).text());
        $("#div_view_author_search").addClass("hidetd");
        $('#auth-view-data tbody').html('');

        $('#author_view_search').focus();

    });

    $('#btn_view_submit').click(function(event){
        event.preventDefault();

        vilidateview = 1

        if(($('#viewdatefldfrom').val() != '') && ($('#viewdatefldto').val() != '') && ($('#author_view_search').val() != '')){
            vilidateview = 0;
        }

        if(vilidateview == 1)
        {
            alertbox_view('Alert','Please select Year and Author or Category as search criteria.','OK'); 

            return false;
        }

        search_view_data();
    });

    function refresh_local_view()
    {
        $('#view-form')[0].reset();
        $('#view_auth_details_display tbody').html('');
        $('#view_auth_details_display tbody').append('<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align: center;"><img id="imgviewedit" src="../image/eye_icon.png"></td><td style="display: none;></td></tr>');
    }

    $('#btn_view_refresh').click(function(event){
        event.preventDefault();
        //refresh_view();
        refresh_local_view();
    });

    function search_view_data(){
        var frmdate = $("#viewdatefldfrom").val();
        var todate = $("#viewdatefldto").val();
        var category = $("#viewcategory").val();
        var author = $("#author_view_search").val();

        var url = $('#application_url_view').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },  
            type: 'POST',
            dataType: 'text',
            url: url + '/displayviewsearch',
            data: {'frmdate': (frmdate != "") ? frmdate : null,'todate': (todate != "") ? todate : null,'category': (category != "0") ? category : null, 'author':(author != "") ? author : null},
            success:function(data)
            {

                $('tbody').html('');

                if(data.length == 0)
                {
                    $('#view_auth_details_display tbody').append('<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align: center;"><img id="imgviewedit" src="../image/eye_icon.png"></td><td style="display: none;></td></tr>')
                }
                else
                {
                    $('tbody').html('');
                    $('#view_auth_details_display tbody').html('');
                    $('#view_auth_details_display tbody').html(data);
                }
            },  
            error:function(xhr, errorType, exception){
                console.log(xhr.responseText)
                console.log('errorType : ' + errorType + " exception : " + exception)
                
                if(xhr.status == 419)
                {
                    $("#myModal_view").css("display", "block");
                }
                else
                {
                    alert(xhr.responseText);
                }
            }
        });
    }

    $('#spanclose_view').click(function() {
        $("#myModal_view").css("display", "none");
    });

    $(window).click(function(e) {
        $("#myModal_view").css("display", "none");
    });

});