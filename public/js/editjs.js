
// disable/enable button based on updatefname,updatemiddlename,updatelname entry
function disableupdateinputs() 
{
    var btndisable = ((!document.getElementById("updatefirstname").value.length 
                    && !document.getElementById("updatemiddlename").value.length 
                    && !document.getElementById("updatelastname").value.length) ? true : false);            

    document.getElementById('btnupdateadd').disabled = btndisable;
    document.getElementById('btnupdaterefresh').disabled = btndisable;
}

//adding authors in table
async function AddUpdateAuthor(e) 
{
    e.preventDefault();

    var table = document.getElementById('update-author-data');

    var fname = document.getElementById("updatefirstname").value,
        mname = document.getElementById("updatemiddlename").value,
        lname = document.getElementById("updatelastname").value,
        slno =  document.getElementById("updateslno").value,
        fullname = fname.charAt(0).toUpperCase() + fname.slice(1).trim() + ' ' + 
                   mname.charAt(0).toUpperCase() + mname.slice(1).trim() + ' ' + 
                   lname.charAt(0).toUpperCase() + lname.slice(1).trim();

    document.getElementById("updatecheckauthorentry").value = "";              
    if(fname == ''){
        document.getElementById("updatecheckauthorentry").value = "showupdatealert";
    }
    
    if(lname == ''){
        document.getElementById("updatecheckauthorentry").value = "showupdatealert";
    }

    if(document.getElementById("updatecheckauthorentry").value == "showupdatealert")
    {
        return false;
    }               

    if(document.getElementById("hdnupdateinput").value == 0)
    {
        var lastrowindex = table.rows.length - 1;
        if(table.rows[lastrowindex].cells[0].innerHTML.trim() == "")
        {
            table.deleteRow(lastrowindex);
        }

        var tr = table.insertRow(table.length);
        var rownumber = (table.rows.length - 1);

        //insert cell into row 
        var td1 = tr.insertCell(0),
            td2 = tr.insertCell(1),
            td3 = tr.insertCell(2),
            td4 = tr.insertCell(3),
            td5 = tr.insertCell(4),
            td6 = tr.insertCell(5),
            td7 = tr.insertCell(6);
            td8 = tr.insertCell(7);
    
        //cell styling    
        td1.style.textAlign = "center";  
        td2.style.paddingLeft = "10px";
        td3.style.textAlign = "center";
        td4.style.textAlign = "center";
        td5.style.display = "none";
        td6.style.display = "none";
        td7.style.display = "none";
        td8.style.display = "none";

        //insert data in table cell
        td1.innerHTML = rownumber + '.';
        td2.innerHTML = fullname;
        td3.innerHTML = "<img id='imgedit' src='../image/edit-icon.png'/>";
        td4.innerHTML = "<img class='del-class' id='imgdelete' src='../image/delete-icon.png'/>";
        td5.innerHTML = '<input type="text" name="updatefirstname[]" value="'+ fname.charAt(0).toUpperCase() + fname.slice(1).trim() +'"/>'; //fname;
        td6.innerHTML = '<input type="text" name="updatemiddlename[]" value="'+ mname.charAt(0).toUpperCase() + mname.slice(1).trim() +'"/>'; //mname;
        td7.innerHTML = '<input type="text" name="updatelastname[]" value="'+ lname.charAt(0).toUpperCase() + lname.slice(1).trim() +'"/>'; //lname;
        td8.innerHTML = '<input type="text" name="updateslno[]" value="'+ rownumber +'"/>'; //lname;
    }
    else
    {
        table.rows[document.getElementById("hdnupdaterindex").value].cells[1].innerHTML = fullname;
        table.rows[document.getElementById("hdnupdaterindex").value].cells[4].innerHTML = '<input type="text" name="updatefirstname[]" value="'+ fname.charAt(0).toUpperCase() + fname.slice(1).trim() +'"/>'; //fname;
        table.rows[document.getElementById("hdnupdaterindex").value].cells[5].innerHTML = '<input type="text" name="updatemiddlename[]" value="'+ mname.charAt(0).toUpperCase() + mname.slice(1).trim() +'"/>'; //mname;
        table.rows[document.getElementById("hdnupdaterindex").value].cells[6].innerHTML = '<input type="text" name="updatelastname[]" value="'+ lname.charAt(0).toUpperCase() + lname.slice(1).trim() +'"/>'; //lname;
        table.rows[document.getElementById("hdnupdaterindex").value].cells[7].innerHTML = '<input type="text" name="updateslno[]" value="'+ slno +'"/>'; //lname;

        document.getElementById("btnupdateadd").innerHTML = '<img src="../image/Add-icon-button-small.png">';
        document.getElementById("btnupdateadd").tabIndex = "19";
        document.getElementById("hdnupdateinput").value = 0;
    }
    
    //clear all author text fields
    document.getElementById("updatefirstname").value = "";
    document.getElementById("updatemiddlename").value = "";
    document.getElementById("updatelastname").value = "";
    document.getElementById("updateslno").value = "";

    //cursor focus in fname text field
    document.getElementById("updatefirstname").focus();

    //disable add button as per conditions
    disableupdateinputs();

    document.getElementById("update-error-author").innerText = "";

    return false;
}

async function refreshupdate(e) 
{
    e.preventDefault();

    //empty fields
    document.getElementById("updatefirstname").value = "";
    document.getElementById("updatemiddlename").value = "";
    document.getElementById("updatelastname").value = "";
    document.getElementById("updateslno").value = "";

    //disable add button as per conditions
    disableupdateinputs();

    if(document.getElementById("hdnupdateinput").value == 1)
    {
        document.getElementById("btnupdateadd").innerHTML = '<img src="../image/Add-icon-button-small.png">';
        document.getElementById("btnupdateadd").tabIndex = "19";
        document.getElementById("hdnupdateinput").value = 0;
    }

    return false;
}

/*************************/
$(document).ready(function()
{
    function alertbox_update(title, msg, $true) {
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

    $('#btnupdateadd').click(function () {
        if($('#updatecheckauthorentry').val() == 'showupdatealert'){
            alertbox_update('Alert','First Name and Last name is mandatory.','OK');  
        }
    });

    // var globalcategory = '';
    var validateupdate = 0;
    var errorplaceholderupdate = 0;

    // globalcategory = $("#updatecategory option:selected").text().toLowerCase();

    // if(globalcategory.toLowerCase() == 'conference'){
    //     $('#updateselimpactfactor').prop('disabled', 'disabled');
    // }
    // else
    // {
    //     $('#updateselimpactfactor').removeAttr('disabled');
    // }

    //delete table data
    $('#update-author-data').on('click', '#imgdelete', function()
    {
        if($("#hdnupdateinput").val() == 0)
        {
            $(this).closest('tr').remove();

            $('table').find('tr').each(function (index) {
                var firstTD = $(this).find('td')[0];
                var lastTD = $(this).find('td')[7];
                var $firstTDJQObject = $(firstTD);
                var $lastTDJQObject = $(lastTD);
                $firstTDJQObject.text(index + '.');
                $lastTDJQObject.text(index);
            });

            var totalTDs = $('#update-author-data').find('tr').length - 1;
            var emptyTDS = 0;

            if (emptyTDS == totalTDs) {
                let imgedit = "<td style='text-align:center;'><img src='../image/edit-icon.png'></td>";
                let imgdelete = "<td style='text-align:center;'><img src='../image/delete-icon.png'></td>";
                let hdntd = "<td hidden></td>"

                markup = "<tr><td></td><td></td>" + imgedit + imgdelete + hdntd + hdntd + hdntd + "</tr>"; 

                tableBody = $("table tbody"); 
                tableBody.append(markup); 
            }
        }
    })

    //edit table data
    $('#update-author-data').on('click', '#imgedit', function(e)
    {
        e.preventDefault();

        var row = $(this);
        var row_index = $(this).closest("tr").index(); //$(this).parent().index();

        $("#hdnupdateinput").val("1");
        $("#hdnupdaterindex").val(row_index+1);

        var fname = row.closest("tr").find("td:eq(4)").find('input').val();
        var mname = row.closest("tr").find("td:eq(5)").find('input').val();
        var lname = row.closest("tr").find("td:eq(6)").find('input').val();
        var slno = row.closest("tr").find("td:eq(7)").find('input').val();

        $('#updatefirstname').val(fname);
        $('#updatemiddlename').val(mname);
        $('#updatelastname').val(lname);
        $('#updateslno').val(slno); 

        disableupdateinputs();

        //changed image icon on add button
        $('#btnupdateadd').text("").append("<img src='../image/edit-icon.png' />");
        $('#btnupdateadd').prop('tabIndex', 20);
    })

    $('#updatecategory').change(function() {
        if($(this).val() != null) {
            var category = $("#updatecategory option:selected").text().toLowerCase();

            if(category.includes('conference')){
                $('#updateimpactfactor').prop('disabled', 'disabled');
                $('#updatearticle').removeAttr('disabled');
            }
            else
            {
                $('#updateimpactfactor').removeAttr('disabled');
                $('#updatearticle').prop('disabled', 'disabled');
                $('#errorupdate-nationality').text('');
            }
        }
    });

    // $('#updatecategory').change(function() {
    //     if($(this).val() != null) {
    //         $('#updateerror-category').text('');

    //         var category = $("#updatecategory option:selected").text().toLowerCase();
    //         globalcategory = category;
            
    //         $('#updatearticle').find('option').remove();
    //         $('#updatearticle').append("<option value='0' disabled selected>Select</option>");

    //         if(category.toLowerCase() == 'conference'){
    //             $('#updateselimpactfactor').prop('disabled', 'disabled');
    //         }
    //         else
    //         {
    //             $('#updateselimpactfactor').removeAttr('disabled');
    //         }

    //         if($('#hdncheckcategory').val() == 0){
    //             $('#hdncheckcategory').val(1);
    //         }

    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },  
    //             type: 'POST',
    //             dataType: 'text',
    //             url: 'getcategory',
    //             data: {'category': category,'checkcategory':$('#hdncheckcategory').val()},
    //             success:function(data)
    //             {
    //                 $('#hdnupdatecategory').val(1);
    //                 console.log('Successfully Posted Category ID!!!!');
    //             },  
    //             error:function(xhr, errorType, exception){
    //                 console.log(xhr.responseText)
    //                 console.log('errorType : ' + errorType + " exception : " + exception)
    //                 alert(xhr.responseText);
    //             }
    //         });

    //     }
    // });

    // $('#updatearticle').click(function() {
    //         $.ajax({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             },
    //             type: 'GET',
    //             dataType: 'json',
    //             url: 'getarticleupdate',
    //             contentType:"application/json; charset=utf-8",
    //             success:function(response)
    //             {
    //                 $.each(response,function(i){
    //                     $('#updatearticle').append("<option value="+ response[i].articleid +">"+ response[i].article +"</option>");
    //                 });

    //                 $('#hdncheckcategory').val(0);
    //             },
    //             error:function(xhr, errorType, exception){
    //                     console.log(xhr.responseText)
    //                     console.log('errorType : ' + errorType + " exception : " + exception)
    //             }
    //         });
    // });

    $("#btnupdate").click(function(e){
        e.preventDefault();

        errorplaceholderupdate = 0;
        validateupdate = 0;
        
        var rowCount = $('#update-author-data tr').length - 1;
        var firstcolvalue = $('#update-author-data').find("td:first").text();

        $('.update-required-message').css('display','block');
        $('.ul-update-required-message li').remove();

        if($('#updatedatefld').val() == ''){
            $('#updatedterror').text('*');
            errorplaceholderupdate = 1;
            validateupdate = 1;
        }
        else{$('#updatedterror').text('');}

        if($('#updateplace').val() == ''){
            $('#errorupdate-place').text('*');
            errorplaceholderupdate = 1;
            validateupdate = 1;
        }

        if($("#updatecategory option:selected").text().toLowerCase() == "journal"){
            if($('#updatetitle').val() == ''){
                if($('#updatetitle').val() == ''){
                    $('#errorupdate-title').text('*');
                    errorplaceholderupdate = 1;
                    validateupdate = 1;
                }
            }
        }

        if($("#updatecategory option:selected").text().toLowerCase().includes("conference")){
            if($('#updatenationality').val() == '0'){
                $('#errorupdate-nationality').text('*');
                errorplaceholderupdate = 1;
                validateupdate = 1;
            }

            if($('#updateconference').val() == ''){
                $('#errorupdate-conference').text('*');
                errorplaceholderupdate = 1;
                validateupdate = 1;
            }
        }

        if(validateupdate == 1)
        {
            $(".ul-update-required-message").append('<li style="color:Red;list-style:none;">  * Required Filelds.</li>');
        }

        if(rowCount == 1 && firstcolvalue == '')
        {
            alertbox_update('Alert','At least one Author is mandatry.','OK'); 
            validateupdate = 1;
        }

        if($.trim($('#updatefirstname').val()) != '' || $.trim($('#updatelastname').val()) != '')
        {
            alertbox_update('Alert','Please add Author entry in grid.','OK');            
            validateupdate = 1;
        }

        if(validateupdate == 0){
            //ajax call to update data to database
            var url = $('#application_url').val();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'text',
                url: url + '/updatetodb',
                data: $('#update-form').serialize(),
                success:function(data)
                {
                    console.log('SUCCESS: ', 'Updated Successfully!!!');
                    window.close();
                },

                error:function(xhr, errorType, exception){
                        console.log(xhr.responseText)
                        console.log('errorType : ' + errorType + " exception : " + exception)
                    if(xhr.status == 419)
                    {
                        $(".modal").css("display", "block");
                    }
                    else
                    {
                        alert(xhr.responseText);
                    }
                }
            });
        }

    });

    $('#spanclose').click(function() {
        $(".modal").css("display", "none");
    });

    $(window).click(function(e) {
        $(".modal").css("display", "none");
    });

    $('#updatedatefld').change(function() {
        if($('#updatedatefld').val() != ''){
            $('#updatedterror').text('');
            errorplaceholderupdate = 0;
        }
    });

    $('#updateplace').keypress(function() {
        if(errorplaceholderupdate = 1 && $(this).val() != "" && $('#errorupdate-place').text() == '*'){
            $('#errorupdate-place').text('');
            errorplaceholderupdate = 0;
        }
    });

    $('#updatetitle').keypress(function() {
        if(errorplaceholderupdate = 1 && $(this).val() != "" && $('#errorupdate-title').text() == '*'){
            $('#errorupdate-title').text('');
            errorplaceholderupdate = 0;
        }
    });

    $('#updateconference').keypress(function() {
        if(errorplaceholderupdate = 1 && $(this).val() != "" && $('#errorupdate-conference').text() == '*'){
            $('#errorupdate-conference').text('');
            errorplaceholderupdate = 0;
        }
    });

});