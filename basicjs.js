// disable/enable button based on fname,middlename,lname entry
function disableinputs() {
    var btndisable =
        !document.getElementById("firstname").value.length &&
        !document.getElementById("middlename").value.length &&
        !document.getElementById("lastname").value.length
            ? true
            : false;

    document.getElementById("btnadd").disabled = btndisable;
    document.getElementById("btnrefresh").disabled = btndisable;
}

async function disablemainbuttons() {
    document.getElementById("defaultopen").disabled = true;
    document.getElementById("btnview").disabled = true;
    document.getElementById("btnsearch").disabled = true;
    document.getElementById("btnprint").disabled = true;
    document.getElementById("btnbibtex").disabled = true;
    document.getElementById("btnlogout").classList.add("hidetd");
    document.getElementById("anrhome").classList.add("hidetd");
}

async function enablemainbuttons() {
    document.getElementById("defaultopen").disabled = false;
    document.getElementById("btnview").disabled = false;
    document.getElementById("btnsearch").disabled = false;
    document.getElementById("btnprint").disabled = false;
    document.getElementById("btnbibtex").disabled = false;
    document.getElementById("btnlogout").classList.remove("hidetd");
    document.getElementById("anrhome").classList.remove("hidetd");
}

async function refresh(e) {
    e.preventDefault();

    //empty fields
    document.getElementById("firstname").value = "";
    document.getElementById("middlename").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("slno").value = "";

    //disable add button as per conditions
    disableinputs();

    if (document.getElementById("hdninput").value == 1) {
        document.getElementById("btnadd").innerHTML =
            '<img src="../image/Add-icon-button-small.png">';
        document.getElementById("btnadd").tabIndex = "20";
        document.getElementById("hdninput").value = 0;
    }

    return false;
}

//Reset the page
function refresh_page() {
    document.getElementById("main-form").reset();

    var table = document.getElementsByTagName("table")[0];

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
    td4.innerHTML =
        "<img class='del-class' id='imgdelete' src='../image/delete-icon.png'/>";

    document.getElementById("hdninput").value = 0;
    document.getElementById("hdnrindex").value = 0;

    document.getElementById("error-authortype").innerHTML = "";
    document.getElementById("error-category").innerHTML = "";
    document.getElementById("error-author").innerHTML = "";

    document.getElementById("required-message").style.display = "none";

    document.getElementById("divupdown").style.display = "none";

    document.getElementById("datefld").focus();
}

// function refresh_view(){
//     document.getElementById('view-form').reset();

//     // var tableviewdetailed = document.getElementById("view_auth_details_display");
//     var tableviewdetailed = document.getElementsByTagName('table')[2];

//     var rownumber = (tableviewdetailed.rows.length - 1);

//     document.getElementById("div_view_author_search").classList.add("hidetd");

//     for(var i = 2;i<tableviewdetailed.rows.length;){

//         tableviewdetailed.deleteRow(i);
//     }

//     if(rownumber > 0)
//     {
//         tableviewdetailed.rows[1].cells[5].style.textAlign = "center";

//         tableviewdetailed.rows[1].cells[0].innerHTML = "";
//         tableviewdetailed.rows[1].cells[1].innerHTML = "";
//         tableviewdetailed.rows[1].cells[2].innerHTML = "";
//         tableviewdetailed.rows[1].cells[3].innerHTML = "";
//         tableviewdetailed.rows[1].cells[4].innerHTML = "";
//         tableviewdetailed.rows[1].cells[5].innerHTML = "<img id='imgview' src='../image/eyeicon.png'/>";
//         tableviewdetailed.rows[1].cells[6].innerHTML = "";
//     }
//     else
//     {
//         var row = tableviewdetailed.insertRow(1);

//         var td0 = row.insertCell(0);
//         var td1 = row.insertCell(1);
//         var td2 = row.insertCell(2);
//         var td3 = row.insertCell(3);
//         var td4 = row.insertCell(4);
//         var td5 = row.insertCell(5);
//         var td6 = row.insertCell(6);

//         td5.style.textAlign = "center";
//         td6.style.display = "none";

//         td0.innerHTML = "";
//         td1.innerHTML = "";
//         td2.innerHTML = "";
//         td3.innerHTML = "";
//         td4.innerHTML = "";
//         td5.innerHTML = "<img id='imgview' src='../image/eyeicon.png'/>";
//         td6.innerHTML = "";
//     }
// }

// function refresh_print(){
//     document.getElementById('print-form').reset();
//     document.getElementById("hidden_category").value = '';
//     document.getElementById("hidden_nationality").value = '';

//     // var table_print = document.getElementById('auth-sel-data');
//     var table_print = document.getElementsByTagName('table')[4];

//     for(var i = 0;i<table_print.rows.length;){
//         // if(table_print.rows.length > 0)
//         // {
//             table_print.deleteRow(i);
//         // }
//     }

//     if(table_print.rows.length == -1)
//     {
//         var row = table_print.insertRow(1);

//         var td0 = row.insertCell(0);
//         var td1 = row.insertCell(1);
//         var td2 = row.insertCell(2);
//         var td3 = row.insertCell(3);

//         td0.innerHTML = "";
//         td1.innerHTML = "";
//         td2.innerHTML = "";
//         td3.innerHTML = "";
//     }

//     // table_print.rows[0].cells[0].innerHTML = "";
//     // table_print.rows[0].cells[1].innerHTML = "";
//     // table_print.rows[0].cells[2].innerHTML = "";
//     // table_print.rows[0].cells[3].innerHTML = "";

//     // var rownumber = (table.rows.length - 1);

//     // var emptyrow = true;
//     // var check = false;

//     // if(rownumber == 0)
//     // {
//     //     for (var r = 0, n = table.rows.length; r < n; r++) {
//     //         for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
//     //             if (table.rows[r].cells[c].innerHTML == ""){
//     //                 emptyrow = false;
//     //             }
//     //             else
//     //             {
//     //                 emptyrow = true;
//     //                 check = true;
//     //                 break;
//     //             }
//     //         }

//     //         if(check == true){break;}
//     //     }

//     //     if (emptyrow == true){
//     //         table.rows[0].cells[0].innerHTML = "";
//     //         table.rows[0].cells[1].innerHTML = "";
//     //         table.rows[0].cells[2].innerHTML = "";
//     //         table.rows[0].cells[3].innerHTML = "";
//     //     }
//     // }
//     // else{
//     //     for(var i = 1;i<table.rows.length;){
//     //         if(table.rows.length > 0)
//     //         {
//     //             table.deleteRow(i);
//     //         }
//     //     }
//     //     table.rows[0].cells[0].innerHTML = "";
//     //     table.rows[0].cells[1].innerHTML = "";
//     //     table.rows[0].cells[2].innerHTML = "";
//     //     table.rows[0].cells[3].innerHTML = "";
//     // }
// }

// function refresh_search(){
//     document.getElementById('searchedit-form').reset();

//     //Search Table
//     // var table_search = document.getElementById('auth_search_edit');
//     var table_search = document.getElementsByTagName('table')[7];
//     // var rownumber = (table.rows.length - 1);
//     for(var i = 1;i<table_search.rows.length;){
//         table_search.deleteRow(i);
//     }

//     //Author Table
//     // var table_search_author = document.getElementById('auth-edit-data');
//     var table_search_author = document.getElementsByTagName('table')[6];

//     for(var i = 0;i<table_search_author.rows.length;){
//         table_search_author.deleteRow(i);
//     }

//     if(table_search_author.rows.length == 0)
//     {
//         var row = table_search_author.insertRow(1);

//         var td0 = row.insertCell(0);
//         var td1 = row.insertCell(1);
//         var td2 = row.insertCell(2);
//         var td3 = row.insertCell(3);

//         td0.innerHTML = "";
//         td1.innerHTML = "";
//         td2.innerHTML = "";
//         td3.innerHTML = "";
//     }0

//     // table_search_author.rows[0].cells[0].innerHTML = "";
//     // table_search_author.rows[0].cells[1].innerHTML = "";
//     // table_search_author.rows[0].cells[2].innerHTML = "";
//     // table_search_author.rows[0].cells[3].innerHTML = "";

//     // var rownumber = (table1.rows.length - 1);

//     // var emptyrow = true;
//     // var check = false;

//     // //Search table
//     // var tableHeaderRowCount = 1;
//     // var rowCount = table.rows.length;
//     // for (var i = tableHeaderRowCount; i < rowCount; i++) {
//     //     table.deleteRow(tableHeaderRowCount);
//     // }

//     // //Author table
//     // if(rownumber == 0)
//     // {
//     //     for (var r = 0, n = table1.rows.length; r < n; r++) {
//     //         for (var c = 0, m = table1.rows[r].cells.length; c < m; c++) {
//     //             if (table1.rows[r].cells[c].innerHTML == ""){
//     //                 emptyrow = false;
//     //             }
//     //             else
//     //             {
//     //                 emptyrow = true;
//     //                 check = true;
//     //                 break;
//     //             }
//     //         }

//     //         if(check == true){break;}
//     //     }

//     //     if (emptyrow == true){
//     //         table1.rows[0].cells[0].innerHTML = "";
//     //         table1.rows[0].cells[1].innerHTML = "";
//     //         table1.rows[0].cells[2].innerHTML = "";
//     //         table1.rows[0].cells[3].innerHTML = "";
//     //     }
//     // }
//     // else{
//     //     for(var i = 1;i<table1.rows.length;){
//     //         table1.deleteRow(i);
//     //     }
//     //     table1.rows[0].cells[0].innerHTML = "";
//     //     table1.rows[0].cells[1].innerHTML = "";
//     //     table1.rows[0].cells[2].innerHTML = "";
//     //     table1.rows[0].cells[3].innerHTML = "";
//     // }
// }

function refresh_bibtex() {
    document.getElementById("bibtex-form").reset();

    document.getElementById("uploadimg").src =
        "https://image.flaticon.com/icons/svg/136/136549.svg";
    document.getElementById("upload").innerText = "Upload document";
    document.getElementById("up").innerText = "";
}

//Get the element with id="defaultopen" to open by default
// var btntest = document.getElementById("defaultopen");
document.getElementById("defaultopen").click();

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";

    evt.currentTarget.className += " active";
}

//adding authors in table
async function AddAuthor(e) {
    e.preventDefault();

    var table = document.getElementsByTagName("table")[0];

    var fname = document.getElementById("firstname").value,
        mname = document.getElementById("middlename").value,
        lname = document.getElementById("lastname").value,
        slno = document.getElementById("slno").value,
        fullname =
            fname.charAt(0).toUpperCase() +
            fname.slice(1).trim() +
            " " +
            mname.charAt(0).toUpperCase() +
            mname.slice(1).trim() +
            " " +
            lname.charAt(0).toUpperCase() +
            lname.slice(1).trim();

    document.getElementById("checkauthorentry").value = "";
    if (fname == "") {
        document.getElementById("checkauthorentry").value = "showalert";
    }

    if (lname == "") {
        document.getElementById("checkauthorentry").value = "showalert";
    }

    if (document.getElementById("checkauthorentry").value == "showalert") {
        return false;
    }

    if (document.getElementById("hdninput").value == 0) {
        //delete empty row from table
        var lastrowindex = table.rows.length - 1;
        if (table.rows[lastrowindex].cells[0].innerHTML.trim() == "") {
            table.deleteRow(lastrowindex);
        }

        //insert new row in atble
        // var newrow = table.insertRow((table.rows.length - 1) + 1);
        var tr = table.insertRow(table.length);
        //row number of table
        var rownumber = table.rows.length - 1;

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
        td1.innerHTML = rownumber + ".";
        td2.innerHTML = fullname;
        td3.innerHTML = "<img id='imgedit' src='../image/edit-icon.png'/>";
        td4.innerHTML =
            "<img class='del-class' id='imgdelete' src='../image/delete-icon.png'/>";
        td5.innerHTML =
            '<input type="text" name="firstname[]" value="' +
            fname.charAt(0).toUpperCase() +
            fname.slice(1).trim() +
            '"/>'; //fname;
        td6.innerHTML =
            '<input type="text" name="middlename[]" value="' +
            mname.charAt(0).toUpperCase() +
            mname.slice(1).trim() +
            '"/>'; //mname;
        td7.innerHTML =
            '<input type="text" name="lastname[]" value="' +
            lname.charAt(0).toUpperCase() +
            lname.slice(1).trim() +
            '"/>'; //lname;
        td8.innerHTML =
            '<input type="text" name="slno[]" value="' + rownumber + '"/>'; //lname;
    } else {
        table.rows[
            document.getElementById("hdnrindex").value
        ].cells[1].innerHTML = fullname;
        table.rows[
            document.getElementById("hdnrindex").value
        ].cells[4].innerHTML =
            '<input type="text" name="firstname[]" value="' +
            fname.charAt(0).toUpperCase() +
            fname.slice(1).trim() +
            '"/>'; //fname;
        table.rows[
            document.getElementById("hdnrindex").value
        ].cells[5].innerHTML =
            '<input type="text" name="middlename[]" value="' +
            mname.charAt(0).toUpperCase() +
            mname.slice(1).trim() +
            '"/>'; //mname;
        table.rows[
            document.getElementById("hdnrindex").value
        ].cells[6].innerHTML =
            '<input type="text" name="lastname[]" value="' +
            lname.charAt(0).toUpperCase() +
            lname.slice(1).trim() +
            '"/>'; //lname;
        table.rows[
            document.getElementById("hdnrindex").value
        ].cells[7].innerHTML =
            '<input type="text" name="slno[]" value="' + slno + '"/>'; //lname;

        document.getElementById("btnadd").innerHTML =
            '<img src="../image/Add-icon-button-small.png">';
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

    if (table.rows.length - 1 > 1) {
        document.getElementById("divupdown").style.display = "block";
    } else {
        document.getElementById("divupdown").style.display = "none";
    }

    document.getElementById("error-author").innerText = "";

    return false;
}

var updownindex;
async function upNdown(direction) {
    if (updownindex != undefined) {
        var rows = document.getElementById("author-data").rows,
            parent = rows[updownindex].parentNode;

        if (direction === "up") {
            if (updownindex > 1) {
                parent.insertBefore(rows[updownindex], rows[updownindex - 1]);
                //When the row go up the index will be equal to index - 1
                updownindex--;
            }
        }

        if (direction === "down") {
            if (updownindex < rows.length - 1) {
                parent.insertBefore(rows[updownindex + 1], rows[updownindex]);
                //When the row go down the index will be equal to index + 1
                updownindex++;
            }
        }

        var table = document.getElementById("author-data");
        for (var i = 1; i < table.rows.length; i++) {
            var firstCol = table.rows[i].cells[0]; //first column
            // firstCol.style.color = 'red'; // or anything you want to do with first col
            firstCol.innerText = i + ".";
        }
    }
}

/*************************/
$(document).ready(function () {
    // $(this).scrollTop(0);

    var usernameasauthor = 0;
    var pub_dup_title = "";
    var pub_dup_conference = "";

    function alertbox_main(title, msg, $true) {
        var $content =
            "<div class='dialog-ovelay'>" +
            "<div class='dialog'><header>" +
            " <h3> " +
            title +
            " </h3> " +
            "<i class='fa fa-close'></i>" +
            "</header>" +
            "<div class='dialog-msg'>" +
            " <p> " +
            msg +
            " </p> " +
            "</div>" +
            "<footer>" +
            "<div class='controls' style='display: flex; justify-content: center; align-items: center;'>" +
            " <button class='button button-danger doAction'>" +
            $true +
            "</button> " +
            "</div>" +
            "</footer>" +
            "</div>" +
            "</div>";
        $("body").prepend($content);

        $(".doAction").click(function () {
            $(this)
                .parents(".dialog-ovelay")
                .fadeOut(500, function () {
                    $(this).remove();
                });
        });
    }

    function confirm_author(title, msg, $true, $false) {
        var $content =
            "<div class='dialog-ovelay'>" +
            "<div class='dialog'><header>" +
            " <h3> " +
            title +
            " </h3> " +
            "<i class='fa fa-close'></i>" +
            "</header>" +
            "<div class='dialog-msg'>" +
            " <p> " +
            msg +
            " </p> " +
            "</div>" +
            "<footer>" +
            "<div class='controls'>" +
            " <button class='button button-danger doAction'>" +
            $true +
            "</button> " +
            " <button class='button button-default cancelAction'>" +
            $false +
            "</button> " +
            "</div>" +
            "</footer>" +
            "</div>" +
            "</div>";
        $("body").prepend($content);

        $(".doAction").click(function () {
            $("#firstname").focus();
            $(this)
                .parents(".dialog-ovelay")
                .fadeOut(500, function () {
                    $(this).remove();
                });
        });

        $(".cancelAction, .fa-close").click(function () {
            $(this)
                .parents(".dialog-ovelay")
                .fadeOut(500, function () {
                    $(this).remove();
                });

            var dup_message = "";

            var dup_creatediv = check_duplicate();

            if (dup_creatediv != "") {
                dup_message =
                    dup_creatediv +
                    "<div> already exist.<br /> Kindly check.. </div>";

                alertbox_main("Alert", dup_message, "OK");
            } else {
                savedata();
            }
        });
    }

    $("#btnadd").click(function () {
        if ($("#checkauthorentry").val() == "showalert") {
            alertbox_main(
                "Alert",
                "First Name and Last name is mandatory.",
                "OK"
            );
        }
    });

    $(window).on("beforeunload", function () {
        //$(window).scrollTop(0);
        $(window).scrollTo(0, 0);
    });

    $("#body").css("min-height", screen.height);
    $("#body").css("min-width", screen.width);

    var validate = 0;
    var errorplaceholder = 0;
    var globalcategory = "";

    var options = {
        backdrop: "static",
        show: true,
        focus: true,
        keyboard: false,
    };

    function refresh_field() {
        $("#article").find("option").not(":first").remove();
        $("#dterror").text("");
        $("#error-place").text("");
        $("#error-title").text("");
        $("#error-conference").text("");
        $("#error-nationality").text("");

        errorplaceholder = 0;
        validate = 0;
    }

    function selectors(selector) {
        var obj = $(selector);

        obj = $.map(obj, function (option) {
            return option.value;
        });
        delete obj[0];

        return obj;
    }

    function sortObject(obj) {
        var arr = [];
        var prop;
        for (prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                arr.push({
                    key: prop,
                    value: obj[prop],
                });
            }
        }
        arr.sort(function (a, b) {
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

    $("#defaultopen").bind("click", function () {
        $(".tabheading").text("Publication > New");
        $(window).scrollTop(0);
        refresh_page();
    });

    $("#btnsearch").bind("click", function () {
        $(".tabheading").text("Publication > Edit");
        $(window).scrollTop(0);
        $(".multicheck").scrollTop(0);
        // refresh_search();

        //refresh searchedit page on tab click
        $("#searchedit-form")[0].reset();

        //Autnor search table
        $("#auth-edit-data tbody").html("");
        $("#auth-edit-data tbody").append(
            "<tr><td></td><td></td><td></td><td></td></tr>"
        );

        //Main data search Table
        $("#auth_search_edit tbody").html("");
    });

    $("#btnprint").bind("click", function () {
        $(".tabheading").text("Publication > Print");
        $(window).scrollTop(0);
        $(".multicheckprint").scrollTop(0);
        // refresh_print();

        //refresh print page on tab click
        $("#print-form")[0].reset();
        $("#hidden_category").val("");
        $("#hidden_category").val("");
        $("#auth-sel-data tbody").html("");
        $("#auth-sel-data tbody").append(
            "<tr><td></td><td></td><td></td><td></td></tr>"
        );
    });

    $("#btnview").bind("click", function () {
        $(".tabheading").text("Publication > View");
        $(window).scrollTop(0);
        $(".multicheckprint").scrollTop(0);
        // refresh_view();

        //refresh view page on tab click
        $("#view-form")[0].reset();
        $("#view_auth_details_display tbody").html("");
        $("#view_auth_details_display tbody").append(
            '<tr><td></td><td></td><td></td><td></td><td></td><td style="text-align: center;"><img id="imgviewedit" src="../image/eye_icon.png"></td><td style="display: none;></td></tr>'
        );
    });

    $("#btnbibtex").bind("click", function () {
        $(".tabheading").text("Publication > BibTex");
        $(window).scrollTop(0);
        $(".multicheckprint").scrollTop(0);
        refresh_bibtex();
    });

    $(".national").click(function () {
        $("#national").prop("checked", true);
        $("#international").prop("checked", false);
    });

    $(".international").click(function () {
        $("#international").prop("checked", true);
        $("#national").prop("checked", false);
    });

    //delete table data
    $("#author-data").on("click", "#imgdelete", function () {
        if ($("#hdninput").val() == 0) {
            $(this).closest("tr").remove();

            $("table")
                .find("tr")
                .each(function (index) {
                    var firstTD = $(this).find("td")[0];
                    var lastTD = $(this).find("td")[7];
                    var $firstTDJQObject = $(firstTD);
                    var $lastTDJQObject = $(lastTD);
                    $firstTDJQObject.text(index + ".");
                    $lastTDJQObject.text(index);
                });

            var totalTDs = $("#author-data").find("tr").length - 1;
            var emptyTDS = 0;

            if (emptyTDS == totalTDs) {
                let imgedit =
                    "<td style='text-align:center;'><img src='../image/edit-icon.png'></td>";
                let imgdelete =
                    "<td style='text-align:center;'><img src='../image/delete-icon.png'></td>";
                let hdntd = "<td hidden></td>";

                markup =
                    "<tr><td></td><td></td>" +
                    imgedit +
                    imgdelete +
                    hdntd +
                    hdntd +
                    hdntd +
                    "</tr>";

                tableBody = $("table tbody");
                tableBody.append(markup);
            }

            if (totalTDs > 1) {
                $("#divupdown").css("display", "block");
            } else {
                $("#divupdown").css("display", "none");
            }
        }
    });

    //edit table data
    $("#author-data").on("click", "#imgedit", function (e) {
        e.preventDefault();

        var row = $(this);
        var row_index = $(this).closest("tr").index(); //$(this).parent().index();

        $("#hdninput").val("1");
        $("#hdnrindex").val(row_index);

        var fname = row.closest("tr").find("td:eq(4)").find("input").val();
        var mname = row.closest("tr").find("td:eq(5)").find("input").val();
        var lname = row.closest("tr").find("td:eq(6)").find("input").val();
        var slno = row.closest("tr").find("td:eq(7)").find("input").val();

        $("#firstname").val(fname);
        $("#middlename").val(mname);
        $("#lastname").val(lname);
        $("#slno").val(slno);

        disableinputs();

        $("#divupdown").css("display", "none");

        //changed image icon on add button
        $("#btnadd").text("").append("<img src='../image/edit-icon.png' />");
        $("#btnadd").prop("tabIndex", 20);
    });

    $(document).on("click", "tr", function (e) {
        updownindex = $(this).index();
        $(this).addClass("highlight").siblings().removeClass("highlight");
        var value = $(this).find("td:first").html();
    });

    //Modal Popup Ranking
    $("#ranking").click(function (e) {
        // $('#modalranking').modal('show')
        e.preventDefault();
        $("#hdnfld").val("rn");
        $("#txtpopup").val("");
        $("#txtpopup").css("border-color", "");
        $("#txtpopup").prop("placeholder", "Ranking");
        $("#error-popup").text("");
        $(".modal-title").text("Ranking");
        $("#selpopup").css("display", "none");
        $("#btnpopupedit").text("Edit");
        $("#modalpopup").modal(options);
    });

    //Modal Popup Broad Area
    $("#broadarea").click(function (e) {
        e.preventDefault();
        $("#hdnfld").val("bn");
        $("#txtpopup").val("");
        $("#txtpopup").css("border-color", "");
        $("#txtpopup").prop("placeholder", "Broad Area");
        $("#error-popup").text("");
        $(".modal-title").text("Broad Area");
        $("#selpopup").css("display", "none");
        $("#btnpopupedit").text("Edit");
        $("#modalpopup").modal(options);
    });

    $("#btnpopupedit").click(function (e) {
        if ($("#btnpopupedit").text() == "Edit") {
            $("#btnpopupedit").text("New");
            $("#selpopup").css("display", "block");

            if ($("#hdnfld").val() == "bn") {
                $("#hdnfld").val("be");
            }

            if ($("#hdnfld").val() == "rn") {
                $("#hdnfld").val("re");
            }
        } else if ($("#btnpopupedit").text() == "New") {
            $("#btnpopupedit").text("Edit");
            $("#selpopup").css("display", "none");

            if ($("#hdnfld").val() == "be") {
                $("#hdnfld").val("bn");
            }

            if ($("#hdnfld").val() == "re") {
                $("#hdnfld").val("rn");
            }
        }

        var url = $("#application_url").val();

        $("#selpopup").empty();
        if ($("#hdnfld").val() == "be" || $("#hdnfld").val() == "bn") {
            $.ajax({
                url: url + "/showbroadarea",
                dataType: "json",
                success: function (data) {
                    $("#selpopup").append(
                        '<option value="0" selected> --Select-- </option>'
                    );
                    $.each(data, function (key, value) {
                        $("#selpopup").append(
                            '<option value="' +
                                value.id +
                                '">' +
                                value.broadarea +
                                "</option>"
                        );
                    });
                },
            });
        }

        if ($("#hdnfld").val() == "re" || $("#hdnfld").val() == "rn") {
            $.ajax({
                url: url + "/showranking",
                dataType: "json",
                success: function (data) {
                    $("#selpopup").append(
                        '<option value="0" selected> --Select-- </option>'
                    );
                    $.each(data, function (key, value) {
                        $("#selpopup").append(
                            '<option value="' +
                                value.id +
                                '">' +
                                value.ranking +
                                "</option>"
                        );
                    });
                },
            });
        }
    });

    $("#selpopup").change(function () {
        var selid = $(this).find(":selected")[0].value;
        var seltext = $(this).find(":selected")[0].text;

        if (selid != 0) {
            $("#txtselid").val(selid);
            $("#txtpopup").val(seltext);
        } else {
            $("#txtselid").val("");
            $("#txtpopup").val("");
        }
    });

    //popup save button click
    $("#popupsave").click(function (e) {
        if ($("#txtpopup").val() == "") {
            e.preventDefault();

            if ($("#hdnfld").val() == "rn" || $("#hdnfld").val() == "re") {
                //Ranking
                $("#error-popup").text("Please enter Ranking.");
            } else if (
                $("#hdnfld").val() == "bn" ||
                $("#hdnfld").val() == "be"
            ) {
                //Broad Area
                $("#error-popup").text("Please enter Broad Area.");
            }
            // else if($('#hdnfld').val() == 'i') //Impact Factor
            // {
            //     $('#error-popup').text('Please enter Impact Factor.');
            // }
            $("#txtpopup").css("border-color", "#cc0000");
        }
    });

    $("#txtpopup").keypress(function () {
        if ($(this).val() == "") {
            $("#txtpopup").css("border-color", "");
            $("#error-popup").text("");
        }
    });

    $("#title").keyup(function () {
        if ($(this).val() != "") {
            //ajax call to get title data

            pub_dup_title = "";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/gettitle",
                data: { duptitle: $("#title").val() },
                success: function (data) {},
                complete: function () {
                    //check duplication
                    $.ajax({
                        url: url + "/check_title_duplication",
                        dataType: "json",
                        success: function (data) {
                            pub_dup_title = data;
                        },
                    });
                },
                error: function (xhr, errorType, exception) {
                    console.log(xhr.responseText);
                    console.log(
                        "errorType : " + errorType + " exception : " + exception
                    );
                },
            });
        }
    });

    $("#conference").keyup(function () {
        if ($(this).val() != "") {
            //ajax call to get cconference data

            pub_dup_conference = "";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "POST",
                dataType: "text",
                url: url + "/getconference",
                data: { dupconference: $("#conference").val() },
                success: function (data) {},
                complete: function () {
                    //check duplication
                    $.ajax({
                        url: url + "/check_conference_duplication",
                        dataType: "json",
                        success: function (data) {
                            pub_dup_conference = data;
                        },
                    });
                },
                error: function (xhr, errorType, exception) {
                    console.log(xhr.responseText);
                    console.log(
                        "errorType : " + errorType + " exception : " + exception
                    );
                },
            });
        }
    });

    function check_duplicate() {
        var dup_creatediv = "";

        // if(pub_dup_title != '' && pub_dup_conference != '')
        // {
        //     if(pub_dup_title !=null && pub_dup_conference != null)
        //     {
        //         dup_creatediv = "<div>" +
        //                         "Title : <label><strong style='color: #0000FF;'>" + pub_dup_title + "</strong></label><br />" +
        //                         "Conference : <label><strong style='color: #0000FF;'>" + pub_dup_conference + "</strong></label>" +
        //                         "</div>";
        //     }
        //     else if(pub_dup_title !=null && pub_dup_conference == null){
        //         dup_creatediv = "<div>" +
        //                     "Title : <label><strong style='color: #0000FF;'>" + pub_dup_title + "</strong></label>" +
        //                     "</div>";
        //     }
        //     else if(pub_dup_title ==null && pub_dup_conference != null){
        //         dup_creatediv = "<div>" +
        //                     "Conference : <label><strong style='color: #0000FF;'>" + pub_dup_conference + "</strong></label>" +
        //                     "</div>";
        //     }
        // }

        if (pub_dup_title != "") {
            if (pub_dup_title != null) {
                dup_creatediv =
                    "<div>" +
                    "Title : <label><strong style='color: #0000FF;'>" +
                    pub_dup_title +
                    "</strong></label>" +
                    "</div>";
            }
        }

        // if(pub_dup_title == '' && pub_dup_conference != '')
        // {
        //     if(pub_dup_conference != null)
        //     {
        //         dup_creatediv = "<div>" +
        //                         "Conference : <label><strong style='color: #0000FF;'>" + pub_dup_conference + "</strong></label>" +
        //                         "</div>";
        //     }
        // }

        return dup_creatediv;
    }

    $("#btnsubmit").click(function (e) {
        e.preventDefault();

        errorplaceholder = 0;
        validate = 0;

        $("#hdnfld").val("m");
        var rowCount = $("#author-data tr").length - 1;
        var firstcolvalue = $("#author-data").find("td:first").text();
        $(".required-message").css("display", "block");
        $(".ul-required-message li").remove();

        if ($("#datefld").val() == "") {
            $("#dterror").text("*");
            errorplaceholder = 1;
            validate = 1;
        } else {
            $("#dterror").text("");
        }

        // if($('#place').val() == ''){
        //     $('#error-place').text('*');
        //     errorplaceholder = 1;
        //     validate = 1;
        // }

        if ($("#authortype").val() == null) {
            $("#error-authortype").text("*");
            errorplaceholder = 1;
            validate = 1;
        }

        if ($("#category").val() == null) {
            $("#error-category").text("*");
            errorplaceholder = 1;
            validate = 1;
        }

        if (globalcategory.length > 0) {
            if ($("#nationality").val() == "0") {
                $("#error-nationality").text("*");
                errorplaceholder = 1;
                validate = 1;
            }

            if (globalcategory == "journal") {
                if ($("#title").val() == "") {
                    $("#error-title").text("*");
                    errorplaceholder = 1;
                    validate = 1;
                }
            }

            if (globalcategory.includes("conference")) {
                if ($("#conference").val() == "") {
                    $("#error-conference").text("*");
                    errorplaceholder = 1;
                    validate = 1;
                }
            }
        }

        if (validate == 1) {
            $(".ul-required-message").append(
                '<li style="color:Red;list-style:none;">  * Required Fields.</li>'
            );
        }

        if (rowCount == 1 && firstcolvalue == "") {
            alertbox_main("Alert", "At least one Author is mandatory.", "OK");
            validate = 1;
        }

        if (
            $.trim($("#firstname").val()) != "" ||
            $.trim($("#lastname").val()) != ""
        ) {
            alertbox_main("Alert", "Please add Author entry in grid.", "OK");
            validate = 1;
        }

        var dup_message = "";

        var dup_creatediv = check_duplicate();

        if (dup_creatediv != "") {
            validate = 1;
            dup_message =
                dup_creatediv +
                "<div> already exist.<br /> Kindly check.. </div>";

            alertbox_main("Alert", dup_message, "OK");
        }

        if (validate == 0) {
            var tbl = $("#author-data tr:has(td)")
                .map(function (i, v) {
                    var $td = $("td", this);
                    return {
                        fname: $td.eq(4).find("input").val(),
                        mname: $td.eq(5).find("input").val(),
                        lname: $td.eq(6).find("input").val(),
                    };
                })
                .get();

            //Check user is in Author Entry
            var loginuser = $("#hdn_login_user").val();

            $.each(tbl, function (key, value) {
                if (
                    loginuser.includes(value.fname) &&
                    loginuser.includes(value.mname) &&
                    loginuser.includes(value.lname) &&
                    usernameasauthor == 0
                ) {
                    if (loginuser.includes(value.lname)) {
                        usernameasauthor = 1;
                    }
                }

                if (value.mname != "") {
                    if (loginuser.includes(value.mname)) {
                        usernameasauthor = 1;
                    }
                }
            });

            if (usernameasauthor == 0) {
                confirm_author(
                    "Confirm",
                    "Login User is not included in Author list.<br /><br />Do you want to add Login User as Author?",
                    "Yes",
                    "No"
                );
            } else {
                savedata();
            }
        }
    });

    function savedata() {
        usernameasauthor = 0;

        var url = $("#application_url").val();

        //ajax call for data save
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            dataType: "text",
            url: url + "/writetodb",
            data: $("#main-form").serialize(),
            success: function (data) {
                console.log("SUCCESS: ", "Saved Successfully!!!");

                $(".ul-required-message li").remove();
                refresh_page();
                refresh_field();

                $(".required-message").css("display", "block");
                $(".ul-required-message").append(
                    '<li style="color:Green;list-style:none;"><strong>Request Saved Successfully.</strong></li>'
                );

                setTimeout(function () {
                    $(".required-message").hide("slow");
                }, 3000);

                $("#datefld").focus();
            },

            error: function (xhr, errorType, exception) {
                console.log(xhr.responseText);
                console.log(
                    "errorType : " + errorType + " exception : " + exception
                );

                if (xhr.status == 419) {
                    $("#myModal").css("display", "block");
                } else {
                    alert(xhr.responseText);
                }
            },
        });
    }

    $("#spanclose").click(function () {
        $("#myModal").css("display", "none");
    });

    $(window).click(function (e) {
        $("#myModal").css("display", "none");
    });

    $("#modalpopup").submit(function (event) {
        event.preventDefault();

        var url = $("#application_url").val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            type: "POST",
            dataType: "text",
            url: url + "/writetodb",
            data: {
                txtpopupeditid: $("#txtselid").val(),
                txtpopupvalue: $("#txtpopup").val(),
                hdnfld: $("#hdnfld").val(),
            },
            success: function (data) {
                console.log("SUCCESS: ", "Saved Popups Successfully!!!");
                $("#div_message").slideDown("slow");
                setTimeout(function () {
                    $("#div_message").slideUp("slow");
                    $("#txtpopup").val("");
                    $("#txtpopup").focus();
                }, 1500);

                var url = $("#application_url").val();

                $("#selpopup").empty();
                if ($("#hdnfld").val() == "be" || $("#hdnfld").val() == "bn") {
                    $.ajax({
                        url: url + "/showbroadarea",
                        dataType: "json",
                        success: function (data) {
                            $("#selpopup").append(
                                '<option value="0" selected> --Select-- </option>'
                            );
                            $.each(data, function (key, value) {
                                $("#selpopup").append(
                                    '<option value="' +
                                        value.id +
                                        '">' +
                                        value.broadarea +
                                        "</option>"
                                );
                            });
                        },
                    });
                }

                if ($("#hdnfld").val() == "re" || $("#hdnfld").val() == "rn") {
                    $.ajax({
                        url: url + "/showranking",
                        dataType: "json",
                        success: function (data) {
                            $("#selpopup").append(
                                '<option value="0" selected> --Select-- </option>'
                            );
                            $.each(data, function (key, value) {
                                $("#selpopup").append(
                                    '<option value="' +
                                        value.id +
                                        '">' +
                                        value.ranking +
                                        "</option>"
                                );
                            });
                        },
                    });
                }
            },

            error: function (xhr, errorType, exception) {
                console.log(xhr.responseText);
                console.log(
                    "errorType : " + errorType + " exception : " + exception
                );
            },
        });
    });

    $("#pagereset").click(function (e) {
        e.preventDefault();

        refresh_page();
        refresh_field();
    });

    $("#datefld").change(function () {
        if ($("#datefld").val() != "") {
            $("#dterror").text("");
            errorplaceholder = 0;
        }
    });

    $("#title").keypress(function () {
        if (
            (errorplaceholder =
                1 && $(this).val() != "" && $("#error-title").text() == "*")
        ) {
            $("#error-title").text("");
            errorplaceholder = 0;
        }
    });

    $("#conference").keypress(function () {
        if (
            (errorplaceholder =
                1 &&
                $(this).val() != "" &&
                $("#error-conference").text() == "*")
        ) {
            $("#error-conference").text("");
            errorplaceholder = 0;
        }
    });

    // $('#place').keypress(function() {
    //     if(errorplaceholder = 1 && $(this).val() != "" && $('#error-place').text() == '*'){
    //         $('#error-place').text('');
    //         errorplaceholder = 0;
    //     }
    // });

    $("#authortype").change(function () {
        if ((errorplaceholder = 1 && $(this).val() != null)) {
            $("#error-authortype").text("");
            errorplaceholder = 0;
        }
    });

    $("#nationality").change(function () {
        if ($(this).val() != 0) {
            $("#error-nationality").text("");
            errorplaceholder = 0;
        }
    });

    $("#category").change(function () {
        if ($(this).val() != null) {
            $("#error-category").text("");

            var category = $("#category option:selected").text().toLowerCase();
            globalcategory = category;
            $("#article").find("option").not(":first").remove();

            $("#article").val($("#article option:first").val());

            if (category.includes("conference")) {
                $("#impactfactor").prop("disabled", "disabled");
                $("#article").removeAttr("disabled");

                var url = $("#application_url").val();
                $.ajax({
                    url: url + "/category",
                    dataType: "json",
                    success: function (data) {
                        $("#article").empty();
                        $("#article").append(
                            '<option value="0" selected> None </option>'
                        );
                        $.each(data, function (key, value) {
                            $("#article").append(
                                '<option value="' +
                                    value.articleid +
                                    '">' +
                                    value.article +
                                    "</option>"
                            );
                        });
                    },
                });
            } else {
                $("#impactfactor").removeAttr("disabled");
                $("#article").prop("disabled", "disabled");
                $("#error-nationality").text("");
            }
        }
    });

    // $('#defaultopen').click(function() {
    //     refresh_page();
    // });

    // $('#btnprint').click(function() {
    //     refresh_print();
    // });

    // $('#btnsearch').click(function() {
    //     refresh_search();
    // });

    // $('#btnadd').click(function() {
    //     $('#firstname').css('border','1px solid #ccc');
    //     $('#firstname').css('color','inherit');
    //     $('#firstname').attr('placeholder',' First Name');

    //     $('#middlename').css('border','1px solid #ccc');
    //     $('#middlename').css('color','inherit');
    //     $('#middlename').attr('placeholder',' Middle Name');

    //     $('#lastname').css('border','1px solid #ccc');
    //     $('#lastname').css('color','inherit');
    //     $('#lastname').attr('placeholder',' Last Name');

    //     $('#error-author-name').text('');
    // });

    $("#btnrefresh").click(function () {
        $("#firstname").css("border", "1px solid #ccc");
        $("#firstname").css("color", "inherit");
        $("#firstname").attr("placeholder", " First Name");

        $("#middlename").css("border", "1px solid #ccc");
        $("#middlename").css("color", "inherit");
        $("#middlename").attr("placeholder", " Middle Name");

        $("#lastname").css("border", "1px solid #ccc");
        $("#lastname").css("color", "inherit");
        $("#lastname").attr("placeholder", " Middle Name");

        $("#error-author").text("");
        $("#error-author-name").text("");
    });

    /* ******************************************************************************************** */

    /* ******************************************************************************************** */
});
