
/***** select value ******/
function dropdown_selected_val(selectObject){
  if(selectObject.id == 'categoryprint'){
    document.getElementById("hidden_category").value = '';
    document.getElementById("hidden_category").value = selectObject.options[selectObject.selectedIndex].value;
  }
  else if(selectObject.id =='nationality'){
    document.getElementById("hidden_nationality").value = '';
    document.getElementById("hidden_nationality").value = selectObject.options[selectObject.selectedIndex].value;
  }
}

function alertbox_print(title, msg, $true) {
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
      });
  });
}

$(document).ready(function()
{
  $('#auth-sel-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');
  
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
              // url: 'printsearch?page=' + page,
              url: url + '/printsearch',
              contentType:"application/json; charset=utf-8",
              // data:{page:page,query:query},
              data:{query:query},
              success:function(data)
              {
                $('tbody').html('');
                if(data.table_data == undefined)
                {
                  $('#auth-sel-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');
                }
                else
                {
                    $('#auth-sel-data tbody').html(data.table_data);
                }
                  $("#dynamic_content").css({"height": "60%", "width": "100%","overflow": "auto","overflow-x": "hidden"});

              },
              error:function(xhr, errorType, exception)
              {
                  console.log(xhr.responseText)
                  console.log('errorType : ' + errorType + " exception : " + exception)
              }
          });
      }
  }

  $('#authsearch').keyup(function() {
      var query = $(this).val();
      
      if(query != '')
      {
        var page = $('hidden_page').val();

        fetch_author_data(query);
      }
      else
      {
        $("#auth-sel-data tr").remove();
        $('#auth-sel-data tbody').append('<tr><td></td><td></td><td></td><td></td></tr>');
      }

  });

  //post fromdate
  $('#prntdatefldfrom').bind('change',function(e) {
    var format_frmdate = '';
    var frmdate = '';
    $('#hidden_frmdt').val('');

    if($('#prntdatefldfrom').val() != '')
    {
        var dt = new Date($('#prntdatefldfrom').val());
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        frmdate = year + "-" + month + "-" + day; //2020-08-21
        format_frmdate = day + "/" + month + "/" + year; //21-08-2020

        $('#hidden_frmdt').val(frmdate);
    }

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printfromdate',
        data: {'frmdate': frmdate,'format_frmdate':format_frmdate},
        success:function()
        {
            // console.log('Successfully Posted print from-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)

            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });

    $('#hidden_frmdt').val('');
  });

  //post to-date
  $('#prntdatefldto').bind('change',function(e) {
    var format_todate = '';
    var todate = '';
    $('#hidden_todt').val('');

    if($('#prntdatefldto').val() != ''){
        var dt = new Date($('#prntdatefldto').val());
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        todate = year + "-" + month + "-" + day; //2020-08-21
        format_todate = day + "/" + month + "/" + year; //21-08-2020

        $('#hidden_todt').val(todate);
    }

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printtodate',
        data: {'todate': todate,'format_todate':format_todate},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });

    $('#hidden_todt').val('');
  });

  //post authortype
  $('#authortypeprint').bind('change',function(e) {
    var authortype = $("#authortypeprint").val();

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printauthortype',
        data: {'authortype':authortype},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post category
  $('#categoryprint').bind('change',function(e) {
    var category = $("#categoryprint").val();

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printcategory',
        data: {'category': category},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post nationality
  $('#nationalityprint').bind('change',function(e) {
    var nationality = $("#nationalityprint").val();

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printnationality',
        data: {'nationality' : nationality},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post title
  $('#titleprint').bind('keyup',function(e) {
    var title = $("#titleprint").val();

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printtitle',
        data: {'title':title},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post conference
  $('#conferenceprint').bind('keyup',function(e) {
    var conference = $("#conferenceprint").val();

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printconference',
        data: {'conference':conference},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post author
  $('#dynamic_content').click(function(e) {
    var obj={};
    var arr = [];

    $("#auth-sel-data .chk").each(function() {
      if ($(this).is(":checked")){

        obj={
          fname : $(this).closest("tr").find("td:eq(1)").html(),
          mname : $(this).closest("tr").find("td:eq(2)").html(),
          lname : $(this).closest("tr").find("td:eq(3)").html()
        };

        arr.push(obj);
      }
    });

    var url = $('#application_url').val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'text',
        url: url + '/printauthor',
        data: {'author' : (arr.length > 0) ? arr : null},
        success:function()
        {
            // console.log('Successfully Posted print to-date data to print page!!!!');
        }, 
        error:function(xhr, errorType, exception){
            console.log(xhr.responseText)
            console.log('errorType : ' + errorType + " exception : " + exception)
            
            if(xhr.status == 419)
            {
                $("#myModal2").css("display", "block");
            }
            else
            {
                alert(xhr.responseText);
            }
        }
    });
  });

  //post ranking
  $('.multicheckprint').bind('click',function(e) {
        var chkobj = {};
        var chkarr = [];

        $(".multicheckprint .rankingprintchk").each(function() {
        if ($(this).is(":checked")){
            chkobj={
                checked : $(this).val()
            };

            chkarr.push(chkobj);
        }
        }); 

        var url = $('#application_url').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'text',
            url: url + '/printranking',
            data: {'ranking' : (chkarr.length > 0) ? chkarr : null},
            success:function()
            {
                // console.log('Successfully Posted print to-date data to print page!!!!');
            }, 
            error:function(xhr, errorType, exception){
                console.log(xhr.responseText)
                console.log('errorType : ' + errorType + " exception : " + exception)
                
                if(xhr.status == 419)
                {
                    $("#myModal2").css("display", "block");
                }
                else
                {
                    alert(xhr.responseText);
                }
            }
        });
  });

    $('#spanclose2').click(function() {
        $("#myModal2").css("display", "none");
    });

    $(window).click(function(e) {
        $("#myModal2").css("display", "none");
    });

  $('#divprint a').bind('click',function(e) {
      var format_frmdate = '';
      var format_todate = '';
      var frmdate = '';
      var todate = '';
      $('#hidden_frmdt').val('');
      $('#hidden_todt').val('');

      var title = $("#titleprint").val();
      var conference = $("#conferenceprint").val();
      var authortype = $("#authortypeprint").val();
      var category = $("#categoryprint").val();
      var nationality = $("#nationalityprint").val();

      var obj={};
      var arr = [];
      
      if($('#prntdatefldfrom').val() != ''){
          var dt = new Date($('#prntdatefldfrom').val());
          var day = dt.getDate();
          var month = dt.getMonth() + 1;
          var year = dt.getFullYear();
          if (day < 10) {
              day = "0" + day;
          }
          if (month < 10) {
              month = "0" + month;
          }
          frmdate = year + "-" + month + "-" + day; //2020-08-21
          format_frmdate = day + "/" + month + "/" + year; //21-08-2020

          $('#hidden_frmdt').val(frmdate);
      }

      if($('#prntdatefldto').val() != ''){
          var dt = new Date($('#prntdatefldto').val());
          var day = dt.getDate();
          var month = dt.getMonth() + 1;
          var year = dt.getFullYear();
          if (day < 10) {
              day = "0" + day;
          }
          if (month < 10) {
              month = "0" + month;
          }
          todate = year + "-" + month + "-" + day; //2020-08-21
          format_todate = day + "/" + month + "/" + year; //21-08-2020

          $('#hidden_todt').val(todate);
      }

      $("#auth-sel-data .chk").each(function() {
        if ($(this).is(":checked")){

          obj={
            fname : $(this).closest("tr").find("td:eq(1)").html(),
            mname : $(this).closest("tr").find("td:eq(2)").html(),
            lname : $(this).closest("tr").find("td:eq(3)").html()
          };

          arr.push(obj);
        }
      });

      var chkobj = {};
      var chkarr = [];

      $(".multicheckprint .rankingprintchk").each(function() {
            if ($(this).is(":checked")){
              chkobj={
                    checked : $(this).val()
                };
    
                chkarr.push(chkobj);
            }
        });  
      
      if((frmdate != '' && todate != '') || authortype != '0' || category != '0' || nationality != '0' || title != '' || conference != '' || arr.length > 0 || chkarr.length > 0){
        // var url = $('#application_url').val();
      }
      else
      {
        alertbox_print('Alert','Select Print criteria.','OK');

        return false;
      }

      $('#hidden_todt').val('');
      $('#hidden_frmdt').val('');
  });

  $('#btnprintrefresh').click(function(e) {
        e.preventDefault();
        refresh_print();

        var url = $('#application_url').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'text',
            url: url + '/printformdata',
            data: {'nodata': 0},
            success:function()
            {
                console.log('Cleared all the sessions on print page!!!!');
            }, 
            error:function(xhr, errorType, exception){
                console.log(xhr.responseText)
                console.log('errorType : ' + errorType + " exception : " + exception)
                
                if(xhr.status == 419)
                {
                    $("#myModal2").css("display", "block");
                }
                else
                {
                    alert(xhr.responseText);
                }
            }
        });
  });

});
