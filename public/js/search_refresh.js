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

