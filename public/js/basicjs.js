
// disable/enable button based on fname,middlename,lname entry
function disableinputs() 
{
    var btndisable = ((!document.getElementById("firstname").value.length 
                    && !document.getElementById("middlename").value.length 
                    && !document.getElementById("lastname").value.length) ? true : false);            

    document.getElementById('btnadd').disabled = btndisable;
    document.getElementById('btnrefresh').disabled = btndisable;
}

async function refresh(e) 
{
    e.preventDefault();

    //empty fields
    document.getElementById("firstname").value = "";
    document.getElementById("middlename").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("slno").value = "";

    //disable add button as per conditions
    disableinputs();

    if(document.getElementById("hdninput").value == 1)
    {
        document.getElementById("btnadd").innerHTML = '<img src="../image/Add-icon-button-small.png">';
        document.getElementById("btnadd").tabIndex = "20";
        document.getElementById("hdninput").value = 0;
    }

    return false;
}

//Reset the page
function refresh_page()
{
    document.getElementById('main-form').reset();

    var table = document.getElementsByTagName('table')[0];
    
    var rows = table.rows;
    var i = rows.length;
    while (--i) {
        rows[i].parentNode.removeChild(rows[i]);
    }

    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = table.insertRow(1);

    // Insert new cells (<td> elements)
    var td1 = row.insertCell(0);
    var td2 = row.insertCell(1);
    var td3 = row.insertCell(2);
    var td4 = row.insertCell(3);

    //cell styling    
    td1.style.textAlign = "center";  
    td2.style.paddingLeft = "10px";
    td3.style.textAlign = "center";
    td4.style.textAlign = "center";

    // Add text to the new cells:
    td1.innerHTML = "";
    td2.innerHTML = "";
    td3.innerHTML = "<img id='imgedit' src='../image/edit-icon.png'/>";
    td4.innerHTML = "<img class='del-class' id='imgdelete' src='../image/delete-icon.png'/>";

    document.getElementById("hdninput").value = 0;
    document.getElementById("hdnrindex").value = 0;

    document.getElementById("error-authortype").innerHTML="";
    document.getElementById("error-category").innerHTML="";
    document.getElementById("error-author").innerHTML="";

    document.getElementById("required-message").style.display = "none";

    document.getElementById("datefld").focus();   
}

function refresh_print(){
    document.getElementById('print-form').reset();
    document.getElementById("hidden_category").value = '';
    document.getElementById("hidden_nationality").value = '';

    var table = document.getElementById('auth-sel-data');
    var rownumber = (table.rows.length - 1);

    var emptyrow = true;
    var check = false;

    if(rownumber == 0)
    {
        for (var r = 0, n = table.rows.length; r < n; r++) {
            for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
                if (table.rows[r].cells[c].innerHTML == ""){
                    emptyrow = false;
                }
                else
                {
                    emptyrow = true;
                    check = true;
                    break;
                }
            }

            if(check == true){break;}
        }

        if (emptyrow == true){
            table.rows[0].cells[0].innerHTML = "";
            table.rows[0].cells[1].innerHTML = "";
            table.rows[0].cells[2].innerHTML = "";
            table.rows[0].cells[3].innerHTML = "";
        }
    }
    else{
        for(var i = 1;i<table.rows.length;){
            table.deleteRow(i);
        }
        table.rows[0].cells[0].innerHTML = "";
        table.rows[0].cells[1].innerHTML = "";
        table.rows[0].cells[2].innerHTML = "";
        table.rows[0].cells[3].innerHTML = "";
    }
}

function refresh_search(){
    document.getElementById('searchedit-form').reset();

    //Search Table
    var table = document.getElementById('auth_search_edit');
    var rownumber = (table.rows.length - 1);

    //Author Table
    var table1 = document.getElementById('auth-edit-data');
    var rownumber = (table1.rows.length - 1);

    var emptyrow = true;
    var check = false;

    //Search table
    var tableHeaderRowCount = 1;
    var rowCount = table.rows.length;
    for (var i = tableHeaderRowCount; i < rowCount; i++) {
        table.deleteRow(tableHeaderRowCount);
    }

    //Author table
    if(rownumber == 0)
    {
        for (var r = 0, n = table1.rows.length; r < n; r++) {
            for (var c = 0, m = table1.rows[r].cells.length; c < m; c++) {
                if (table1.rows[r].cells[c].innerHTML == ""){
                    emptyrow = false;
                }
                else
                {
                    emptyrow = true;
                    check = true;
                    break;
                }
            }

            if(check == true){break;}
        }

        if (emptyrow == true){
            table1.rows[0].cells[0].innerHTML = "";
            table1.rows[0].cells[1].innerHTML = "";
            table1.rows[0].cells[2].innerHTML = "";
            table1.rows[0].cells[3].innerHTML = "";
        }
    }
    else{
        for(var i = 1;i<table1.rows.length;){
            table1.deleteRow(i);
        }
        table1.rows[0].cells[0].innerHTML = "";
        table1.rows[0].cells[1].innerHTML = "";
        table1.rows[0].cells[2].innerHTML = "";
        table1.rows[0].cells[3].innerHTML = "";
    }
}

//Get the element with id="defaultopen" to open by default
// var btntest = document.getElementById("defaultopen");
document.getElementById("defaultopen").click();

function openTab(evt, tabName)
{
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for(i = 0; i < tabcontent.length; i++)
    {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for(i = 0; i < tablinks.length; i++)
    {
        tablinks[i].className = tablinks[i].className.replace(" active","");
    }

    document.getElementById(tabName).style.display = "block";

    evt.currentTarget.className += " active";
}

//adding authors in table
async function AddAuthor(e) 
{
    e.preventDefault();

    var table = document.getElementsByTagName('table')[0];

    var fname = document.getElementById("firstname").value,
        mname = document.getElementById("middlename").value,
        lname = document.getElementById("lastname").value,
        slno =  document.getElementById("slno").value,
        fullname = fname.charAt(0).toUpperCase() + fname.slice(1).trim() + ' ' + 
                   mname.charAt(0).toUpperCase() + mname.slice(1).trim() + ' ' + 
                   lname.charAt(0).toUpperCase() + lname.slice(1).trim();

    document.getElementById("checkauthorentry").value = "";              
    if(fname == ''){
        document.getElementById("checkauthorentry").value = "showalert";
    }
    
    if(lname == ''){
        document.getElementById("checkauthorentry").value = "showalert";
    }

    if(document.getElementById("checkauthorentry").value == "showalert")
    {
        return false;
    }
                        
    if(document.getElementById("hdninput").value == 0)
    {
        //delete empty row from table
        var lastrowindex = table.rows.length - 1;
        if(table.rows[lastrowindex].cells[0].innerHTML.trim() == "")
        {
            table.deleteRow(lastrowindex);
        }

        //insert new row in atble
        // var newrow = table.insertRow((table.rows.length - 1) + 1);
        var tr = table.insertRow(table.length);
        //row number of table
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
        td5.innerHTML = '<input type="text" name="firstname[]" value="'+ fname.charAt(0).toUpperCase() + fname.slice(1).trim() +'"/>'; //fname;
        td6.innerHTML = '<input type="text" name="middlename[]" value="'+ mname.charAt(0).toUpperCase() + mname.slice(1).trim() +'"/>'; //mname;
        td7.innerHTML = '<input type="text" name="lastname[]" value="'+ lname.charAt(0).toUpperCase() + lname.slice(1).trim() +'"/>'; //lname;
        td8.innerHTML = '<input type="text" name="slno[]" value="'+ rownumber +'"/>'; //lname;
    }
    else
    {
        table.rows[document.getElementById("hdnrindex").value].cells[1].innerHTML = fullname;
        table.rows[document.getElementById("hdnrindex").value].cells[4].innerHTML = '<input type="text" name="firstname[]" value="'+ fname.charAt(0).toUpperCase() + fname.slice(1).trim() +'"/>'; //fname;
        table.rows[document.getElementById("hdnrindex").value].cells[5].innerHTML = '<input type="text" name="middlename[]" value="'+ mname.charAt(0).toUpperCase() + mname.slice(1).trim() +'"/>'; //mname;
        table.rows[document.getElementById("hdnrindex").value].cells[6].innerHTML = '<input type="text" name="lastname[]" value="'+ lname.charAt(0).toUpperCase() + lname.slice(1).trim() +'"/>'; //lname;
        table.rows[document.getElementById("hdnrindex").value].cells[7].innerHTML = '<input type="text" name="slno[]" value="'+ slno +'"/>'; //lname;

        document.getElementById("btnadd").innerHTML = '<img src="../image/Add-icon-button-small.png">';
        document.getElementById("btnadd").tabIndex = "20";
        document.getElementById("hdninput").value = 0;
    }
    
    //clear all author text fields
    document.getElementById("firstname").value = "";
    document.getElementById("middlename").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("slno").value = "";

    //cursor focus in fname text field
    document.getElementById("firstname").focus();

    //disable add button as per conditions
    disableinputs();

    document.getElementById("error-author").innerText = "";

    return false;
}

/*************************/
$(document).ready(function()
{   
    // $(this).scrollTop(0);

    function alertbox_main(title, msg, $true) {
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

    $('#btnadd').click(function () {
        if($('#checkauthorentry').val() == 'showalert'){
            alertbox_main('Alert','First Name and Last name is mandatory.','OK');  
        }
    });

    $(window).on('beforeunload', function(){
        //$(window).scrollTop(0);
        $(window).scrollTo(0, 0); 
    });

    $('#body').css('min-height', screen.height);
    $('#body').css('min-width', screen.width);      

    var validate = 0;
    var errorplaceholder = 0;
    var globalcategory = '';

    var options = {
        'backdrop' : 'static',
        'show' : true,
        'focus' : true
    }

    function refresh_field() {
        $('#article').find('option').not(':first').remove();
        $('#dterror').text('');
        $('#error-place').text('');
        $('#error-title').text('');
        $('#error-conference').text('');
        $('#error-nationality').text('');

        errorplaceholder = 0
        validate = 0
    }

    function selectors(selector) {  
        var obj = $(selector);

        obj = $.map(obj ,function(option) {
            return option.value;
        });
        delete obj[0];

        return obj;
    };

    function sortObject(obj) {
        var arr = [];
        var prop;
        for (prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                arr.push({
                    'key': prop,
                    'value': obj[prop]
                });
            }
        }
        arr.sort(function(a, b) {
            return a.value - b.value;
        });
        return arr; // returns array
    }

    // $("#home a").trigger('click');

    // $('#home a').bind('click',function(e){
    //     //e.preventDefault();
    //     window.location.href = "home";
    // });    

    // $('#lipublication a').bind('click',function(e){
    //     $(".tab").css("display", "inline");
        // window.location.href = "publication";
        // $(".layoutmain").css("display", "flex");
        // $('#tabheading').text('Publication');
        // $("#defaultopen").trigger('click');
        // e.preventDefault();
    // });

    $('#defaultopen').bind('click',function(){
        $('.tabheading').text('Publication > New');
        $(window).scrollTop(0);
    });

    $('#btnsearch').bind('click',function(){
        $('.tabheading').text('Publication > Edit');
        $(window).scrollTop(0);
        $('.multicheck').scrollTop(0);
    });

    $('#btnprint').bind('click',function(){
        $('.tabheading').text('Publication > Print');
        $(window).scrollTop(0);
        $('.multicheckprint').scrollTop(0);
    });

    $(".national").click(function(){
        $("#national").prop("checked", true);
        $("#international").prop("checked", false);
    });

    $(".international").click(function(){
        $("#international").prop("checked", true);
        $("#national").prop("checked", false);
    });

    //delete table data
    $('#author-data').on('click', '#imgdelete', function()
    {
        if($("#hdninput").val() == 0)
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

            var totalTDs = $('#author-data').find('tr').length - 1;
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
    $('#author-data').on('click', '#imgedit', function(e)
    {
        e.preventDefault();

        var row = $(this);
        var row_index = $(this).closest("tr").index(); //$(this).parent().index();

        $("#hdninput").val("1");
        $("#hdnrindex").val(row_index);

        var fname = row.closest("tr").find("td:eq(4)").find('input').val();
        var mname = row.closest("tr").find("td:eq(5)").find('input').val();
        var lname = row.closest("tr").find("td:eq(6)").find('input').val();
        var slno = row.closest("tr").find("td:eq(7)").find('input').val();

        $('#firstname').val(fname);
        $('#middlename').val(mname);
        $('#lastname').val(lname);
        $('#slno').val(slno); 

        disableinputs();

        //changed image icon on add button
        $('#btnadd').text("").append("<img src='../image/edit-icon.png' />");
        $('#btnadd').prop('tabIndex', 20);
    })

    //Modal Popup Ranking
    $('#ranking').click(function(){
        // $('#modalranking').modal('show')
        $('#hdnfld').val('r');
        $('#txtpopup').val('');
        $('#txtpopup').css('border-color','');
        $('#txtpopup').prop('placeholder','Ranking');
        $('#error-popup').text('');
        $('.modal-title').text('Ranking');
        $('#modalpopup').modal(options);
    });

    //Modal Popup Broad Area
    $('#broadarea').click(function(){
        $('#hdnfld').val('b');
        $('#txtpopup').val('');
        $('#txtpopup').css('border-color','');
        $('#txtpopup').prop('placeholder','Broad Area');
        $('#error-popup').text('');
        $('.modal-title').text('Broad Area');
        $('#modalpopup').modal(options);
    });

    //popup save button click
    $("#popupsave").click(function(e){

        if($('#txtpopup').val() == '')
        {
            e.preventDefault();

            if( $('#hdnfld').val() == 'r') //Ranking
            {
                $('#error-popup').text('Please enter Ranking.');
            }
            else if($('#hdnfld').val() == 'b') //Broad Area
            { 
                $('#error-popup').text('Please enter Broad Area.');
            }
            else if($('#hdnfld').val() == 'i') //Impact Factor
            {
                $('#error-popup').text('Please enter Impact Factor.');
            }
            $('#txtpopup').css('border-color','#cc0000');
        }
    });

    $( "#txtpopup" ).keypress(function() {
        if($(this).val() == '')
        {
            $('#txtpopup').css('border-color','');
            $('#error-popup').text('');
        }
    });

    $("#btnsubmit").click(function(e){
        e.preventDefault();

        errorplaceholder = 0;
        validate = 0;

        $('#hdnfld').val('m');
        var rowCount = $('#author-data tr').length - 1;
        var firstcolvalue = $('#author-data').find("td:first").text();
        $('.required-message').css('display','block');
        $('.ul-required-message li').remove(); 

        if($('#datefld').val() == ''){
            $('#dterror').text('*');
            errorplaceholder = 1;
            validate = 1;
        }
        else{$('#dterror').text('');}

        if($('#place').val() == ''){
            $('#error-place').text('*');
            errorplaceholder = 1;
            validate = 1;
        }

        if($('#authortype').val() == null){
            $('#error-authortype').text('*');
            errorplaceholder = 1;
            validate = 1;
        }

        if($('#category').val() == null){
            $('#error-category').text('*');
            errorplaceholder = 1;
            validate = 1;
        }

        if(globalcategory.length > 0){
            if(globalcategory == 'journal'){
                if($('#title').val() == ''){
                    $('#error-title').text('*');
                    errorplaceholder = 1;
                    validate = 1;
                }
            }

            if(globalcategory.includes('conference')){
                if($('#nationality').val() == '0'){
                    $('#error-nationality').text('*');
                    errorplaceholder = 1;
                    validate = 1;
                }

                if($('#conference').val() == ''){
                    $('#error-conference').text('*');
                    errorplaceholder = 1;
                    validate = 1;
                }
            }
        }

        if(validate == 1)
        {
            $(".ul-required-message").append('<li style="color:Red;list-style:none;">  * Required Filelds.</li>');
        }

        if(rowCount == 1 && firstcolvalue == '')
        {
            alertbox_main('Alert','At least one Author is mandatry.','OK'); 
            validate = 1;   
        }

        if($.trim($('#firstname').val()) != '' || $.trim($('#lastname').val()) != '')
        {
            alertbox_main('Alert','Please add Author entry in grid.','OK');            
            validate = 1;
        }

        if(validate == 0)
        {
            var url = $('#application_url').val();

            //ajax call for data save
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'text',
                url: url + '/writetodb',
                data: $('#main-form').serialize(),
                success:function(data)
                {
                    console.log('SUCCESS: ', 'Saved Successfully!!!');

                    refresh_page();
                    refresh_field();
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

    $("#modalpopup").submit(function(event) {
        event.preventDefault();

        var url = $('#application_url').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            dataType: 'text',
            url: url + '/writetodb',
            data: {'txtpopupvalue': $('#txtpopup').val(),'hdnfld': $('#hdnfld').val()},
            success:function(data)
            {
                console.log('SUCCESS: ', 'Saved Popups Successfully!!!');
                $("#div_message").slideDown('slow');
                setTimeout(function(){ 
                    $('#div_message').slideUp('slow'); 
                    $('#txtpopup').val('');
                    $('#txtpopup').focus();
                }, 1000 );
            },

            error:function(xhr, errorType, exception){
                    console.log(xhr.responseText)
                    console.log('errorType : ' + errorType + " exception : " + exception)
            }
        });

    });

    $("#pagereset").click(function(e){
        e.preventDefault();

        refresh_page();
        refresh_field();
    });

    $('#datefld').change(function() {
        if($('#datefld').val() != ''){
            $('#dterror').text('');
            errorplaceholder = 0;
        }
    });

    $('#title').keypress(function() {
        if(errorplaceholder = 1 && $(this).val() != "" && $('#error-title').text() == '*'){
            $('#error-title').text('');
            errorplaceholder = 0;
        }
    });

    $('#conference').keypress(function() {
        if(errorplaceholder = 1 && $(this).val() != "" && $('#error-conference').text() == '*'){
            $('#error-conference').text('');
            errorplaceholder = 0;
        }
    });

    $('#place').keypress(function() {
        if(errorplaceholder = 1 && $(this).val() != "" && $('#error-place').text() == '*'){
            $('#error-place').text('');
            errorplaceholder = 0;
        }
    });
    
    $('#authortype').change(function() {
        if(errorplaceholder = 1 && $(this).val() != null) {
            $('#error-authortype').text('');
            errorplaceholder = 0;
        }
    });

    $('#nationality').change(function() {
        if($(this).val() != 0) {
            $('#error-nationality').text('');
            errorplaceholder = 0;
        }
    });
    
    $('#category').change(function() {
        if($(this).val() != null) {
            $('#error-category').text('');

            var category = $("#category option:selected").text().toLowerCase();
            globalcategory = category;
            $('#article').find('option').not(':first').remove();

            $("#article").val($("#article option:first").val());

            if(category.includes('conference')){
                $('#impactfactor').prop('disabled', 'disabled');
                $('#article').removeAttr('disabled');

                var url = $('#application_url').val();
                $.ajax({
                    url: url + "/category",
                    dataType: "json",
                    success: function (data) {
                        $('#article').empty();
                        $('#article').append('<option value="0" selected> None </option>');
                        $.each(data, function (key, value) {
                            $('#article').append('<option value="'+ value.articleid + '">' + value.article + '</option>');
                        });
                    }
                });
            }
            else
            {
                $('#impactfactor').removeAttr('disabled');
                $('#article').prop('disabled', 'disabled');
                $('#error-nationality').text('');
            }
            
        }
    });   

    $('#defaultopen').click(function() {
        refresh_page();
    }); 

    $('#btnprint').click(function() {
        refresh_print();
    });

    $('#btnsearch').click(function() {
        refresh_search();
    });

    $('#btnadd').click(function() {
        $('#firstname').css('border','1px solid #ccc');
        $('#firstname').css('color','inherit');
        $('#firstname').attr('placeholder',' First Name');

        $('#middlename').css('border','1px solid #ccc');
        $('#middlename').css('color','inherit');
        $('#middlename').attr('placeholder',' Middle Name');

        $('#lastname').css('border','1px solid #ccc');
        $('#lastname').css('color','inherit');
        $('#lastname').attr('placeholder',' Middle Name');

        $('#error-author-name').text('');
    });

    $('#btnrefresh').click(function() {
        $('#firstname').css('border','1px solid #ccc');
        $('#firstname').css('color','inherit');
        $('#firstname').attr('placeholder',' First Name');

        $('#middlename').css('border','1px solid #ccc');
        $('#middlename').css('color','inherit');
        $('#middlename').attr('placeholder',' Middle Name');

        $('#lastname').css('border','1px solid #ccc');
        $('#lastname').css('color','inherit');
        $('#lastname').attr('placeholder',' Middle Name');

        $('#error-author').text('');
        $('#error-author-name').text('');
    });

/* ******************************************************************************************** */

/* ******************************************************************************************** */

});