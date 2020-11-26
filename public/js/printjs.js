
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

      // category = '';
      // if($('#hidden_category').val() != ''){
      //     category = $("#hidden_category").val().toLowerCase();
          
      //     if(category == 'none'){
      //       category = null;
      //     }
      // }

      // nationality = '';
      // if($('#hidden_nationality').val() != ''){
      //     nationality = $("#hidden_nationality").val();

      //     if(nationality == '0'){
      //       nationality = null;
      //     }
      // }

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
        var url = $('#application_url').val();

        $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: 'POST',
              dataType: 'text',
              url: url + '/printformdata',
              // data: $('#print-form').serialize(),
              data: {'frmdate': frmdate,'todate': todate,'format_frmdate':format_frmdate,'format_todate':format_todate,  'authortype':authortype, 'category': category, 'nationality' : nationality, 'title':title, 'conference':conference, 'author' : (arr.length > 0) ? arr : null, 'ranking':(chkarr.length > 0) ? chkarr : null},
              success:function()
              {
                  console.log('Successfully Posted printing data to print page!!!!');
              }, 
              error:function(xhr, errorType, exception){
                  console.log(xhr.responseText)
                  console.log('errorType : ' + errorType + " exception : " + exception)
                  alert(xhr.responseText);
              }
          });
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
  });

});
