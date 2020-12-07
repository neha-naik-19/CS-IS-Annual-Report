$(document).ready(function(){

    var getheaderid = 0;

    addCheckbox();

    $('#auth-edit-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');

    function Confirm(title, msg, $true, $false) {
        var $content =  "<div class='dialog-ovelay'>" +
                        "<div class='dialog'><header>" +
                        " <h3> " + title + " </h3> " +
                        "<i class='fa fa-close'></i>" +
                            "</header>" +
                            "<div class='dialog-msg'>" +
                                " <p> " + msg + " </p> " +
                            "</div>" +
                            "<footer>" +
                                "<div class='controls'>" +
                                    " <button class='button button-danger doAction'>" + $true + "</button> " +
                                    " <button class='button button-default cancelAction'>" + $false + "</button> " +
                                "</div>" +
                            "</footer>" +
                        "</div>" +
                        "</div>";
        $('body').prepend($content);

        $('.doAction').click(function () {
            delete_data(getheaderid);
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });

            search_data();
        });

        $('.cancelAction, .fa-close').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
            $(this).remove();
            });
        });
    }

    function alertbox(title, msg, $true) {
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
            delete_data(getheaderid);
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });
        });
    }

    function selected_author_data()
    {
        var objselect={};
        var arrselect = [];

        $("#auth-edit-data .chkrnk").each(function() {
            if ($(this).is(":checked")){
    
                objselect={
                    fname : $(this).closest("tr").find("td:eq(1)").html(),
                    mname : $(this).closest("tr").find("td:eq(2)").html(),
                    lname : $(this).closest("tr").find("td:eq(3)").html()
                };
    
                arrselect.push(objselect);
            }
        });

        return arrselect;
    }

    function ranking_selected_data()
    {
        var objcheck = {};
        var arrcheck = [];

        $(".multicheck .rankingchk").each(function() {
            if ($(this).is(":checked")){
    
                objcheck={
                    checked : $(this).val()
                };
    
                arrcheck.push(objcheck);
            }
        });

        return arrcheck;
    }

    function search_data(){
        var frmdate = $("#searchdatefldfrom").val();
        var todate = $("#searchdatefldto").val();
        var authortype = $("#authortypeselect").val();
        var category = $("#categoryselect").val();
        var nationality = $("#nationalityselect").val();
        var title = $("#titlesearch").val();
        var conference = $("#conferencesearch").val();
        var rankingdata = ranking_selected_data();
        var authordata = selected_author_data();

        var url = $('#application_url').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },  
            type: 'POST',
            dataType: 'text',
            url: url + '/displaysearch',
            data: {'frmdate': (frmdate != "") ? frmdate : null,'todate': (todate != "") ? todate : null,'authortype':(authortype != "0") ? authortype : null, 'category': (category != "0") ? category : null, 'nationality' : (nationality != "0") ? nationality : null, 'title':(title != "") ? title : null, 'conference':(conference != "") ? conference : null, 'ranking':(rankingdata.length > 0) ? rankingdata : null, 'author' : (authordata.length > 0) ? authordata : null},
            success:function(data)
            {
                //$('#auth_search_edit tbody').html(data.search_data);
                $('#auth_search_edit tbody').html(data);
            },  
            error:function(xhr, errorType, exception){
                console.log(xhr.responseText)
                console.log('errorType : ' + errorType + " exception : " + exception)
                
                if(xhr.status == 419)
                {
                    $("#myModal1").css("display", "block");
                }
                else
                {
                    alert(xhr.responseText);
                }
            }
        });
    };

    $('#spanclose1').click(function() {
        $("#myModal1").css("display", "none");
    });

    $(window).click(function(e) {
        $("#myModal1").css("display", "none");
    });

    function delete_data(headerid){

        var url = $('#application_url').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },  
            type: 'POST',
            dataType: 'json',
            url: url + '/deletesearch/'+ headerid,
            // data: $('#searchedit-form').serialize(),
            success:function(data)
            {
                console.log('Delete from table!!!!');
            },  
            error:function(xhr, errorType, exception){
                console.log(xhr.responseText)
                console.log('errorType : ' + errorType + " exception : " + exception)
            }
        });
    };

    function fetch_author_data(query = ''){
        if(query != '')
        {
            var url = $('#application_url').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                dataType: 'json',
                url: url + '/editsearch',
                contentType:"application/json; charset=utf-8",
                data:{query:query},
                success:function(data)
                {
                  $('tbody').html('');
                  if(data.table_data == undefined)
                  {
                    $('#auth-edit-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');
                  }
                  else
                  {
                      $('#auth-edit-data tbody').html(data.table_data);
                  }
                    $("#dynamic_edit_content").css({"height": "60%", "width": "100%","overflow": "auto","overflow-x": "hidden"});
  
                },
                error:function(xhr, errorType, exception)
                {
                    console.log(xhr.responseText)
                    console.log('errorType : ' + errorType + " exception : " + exception)
                }
            });
        }
    }

    $('#authorsearch').keyup(function() {
        var query = $(this).val();
        
        if(query != '')
        {
          var page = $('hidden_page').val();
  
          fetch_author_data(query);
        }
        else
        {
          $("#auth-edit-data tr").remove();
          $('#auth-edit-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');
        }
  
    });

    $('#btnsearchedit').click(function(e) {
        e.preventDefault();

        var authordata = selected_author_data();
        var rankingdata = ranking_selected_data();

        if($('#searchdatefldfrom').val() == '' && $('#searchdatefldto').val() == '' && $('#authortypeselect').val() == '0'
        && $('#categoryselect').val() == '0' && $('#nationalityselect').val() == '0' && $('#titlesearch').val() == ''
        && $('#conferencesearch').val() == '' && rankingdata.length == 0 && authordata.length == 0){
            alertbox('Alert','Select search criteria.','OK');

            return false;
        }

        search_data();
    });

    $('#auth_search_edit').on('click', '#imgsearchdelete', function(){

        getheaderid = $(this).closest("tr").find('td:eq(18)').text();

        Confirm('Delete', 'Are you sure you want to delete this record?', 'Yes', 'Cancel');
    });

    $('#btnsearchrefresh').click(function(e) {
        e.preventDefault();
        refresh_search();
    });

    function addCheckbox() {
        var url = $('#application_url').val();
        var container = $('.multicheck');
        var inputs = container.find('input');

        $('.multicheck').empty();

        $.ajax({
            url: url + "/allrankings",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) {
                    $('.multicheck').append('<label><input type="checkbox" class="rankingchk" name="rankingoption[]" value="'+ value.id +'" />'+ ' ' + value.ranking +'</label>');
                    $('.multicheckprint').append('<label><input type="checkbox" class="rankingprintchk" name="rankingprintoption[]" value="'+ value.id +'" />'+ ' ' + value.ranking +'</label>');
                });
            }
        });
    }
});
