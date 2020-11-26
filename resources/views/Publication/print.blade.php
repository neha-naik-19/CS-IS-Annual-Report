
<input type="hidden" name="application_url" id="application_url_print" value="{{URL::to(Request::route()->getPrefix())}}"/>

<div class="mainprnt">
    <div class="divprint-1">
        <label class="lblprint">Date From</label>
        <input class="dtprint" type="date" tabindex="1" name="prtdatefldfrom" id="prntdatefldfrom">
        <span id="error-fromdt" class="text-danger"></span>
    </div> <!-- divprint-1 -->

    <div class="divprint-2">
        <label class="lblprint">Date To</label>
        <input class="dtprint" type="date" tabindex="2" name="prtdatefldto" id="prntdatefldto">
        <span id="error-todt" class="text-danger"></span>
    </div> <!-- divprint-2 -->

    <div class="divprint-2"> 
        <label class="lblsearch">Author Type</label>
        <select class="selectsearch" name="authortypeprint" id="authortypeprint" tabindex="3">
            <option value='0' selected >None</option>
            @foreach($authortypeData['data'] as $authortype)
                <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
            @endforeach
        </select>
    </div> <!-- divprint-2 -->

    <div class="divprint-2"> 
        <label class="lblprint">Category</label>
        <select class="selectprintpage" name="slct" id="categoryprint" onchange="dropdown_selected_val(this)" tabindex="3">
            <option value='0' selected >None</option  >
            <!-- <option value="1">Conference/Workshop</option>
            <option value="2">Journal</option> -->
            @foreach($categoryData['data'] as $category)
                <option value='{{ $category->id }}'>{{ $category->category }}</option>
            @endforeach
        </select>
    </div> <!-- divprint-2 -->

    <div class="divprint-2"> 
        <label class="lblprint">Demography</label>
        <select class="selectprintpage" name="slct" id="nationalityprint" onchange="dropdown_selected_val(this)" tabindex="4">
            <option value='0' selected >None</option>
            <option value="1">National</option> 
            <option value="2">International</option>
        </select>
    </div> <!-- divprint-2 -->

    <div class="divprint-2">
        <label class="lblprint">Ranking</label> 
        <div class="multicheckprint">

        </div>
    </div>
</div>

<div class="mainsearch-1">
    <div class="divsearch-3">
        <label class="lblsearch" for="lblsearch">Title of the Paper</label>
        <input type="text" class="inputsearch" name="titleprint" id="titleprint" placeholder=" Title of the Paper" tabindex="8">
    </div>

    <div class="divsearch-3">
        <label class="lblsearch" for="lblsearch">Name of Conference/Journal</label>
        <input type="text" class="inputsearch" name="conferenceprint" id="conferenceprint" placeholder=" Name of Conference/Journal" tabindex="9">
    </div>
</div> <!-- mainsearch-1 -->

<div class="author-search">
    <div style="height: 22em; border:1px solid #ccc; border-radius: 5px; width:67em;">
        <div class="panel-body">
            <input type="text" class="inputprintpage" name="authsearch" id="authsearch" placeholder="Search Author" tabindex="5">
        </div>
        <div id="dynamic_header">
            <table id="auth-sel-header" class="scroll" style="table-layout:fixed;">
                <thead id="print-tablehead">
                    <tr>
                        <th style="text-align: center;">Select</th>  
                        <th>First name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                    </tr>
                </thead>
            </table>
        </div> 
        <div id="dynamic_content" style="margin-top: -12px;">   
            <table id="auth-sel-data" class="scroll" style="table-layout:fixed;">
                <tbody id="print-tablebody">
                        
                </tbody>    
            </table>
            <input type="hidden" name='hidden_page' id="hidden_page" value="1">
            <input type="hidden" name='hidden_category' id="hidden_category" value=''>
            <input type="hidden" name='hidden_nationality' id="hidden_nationality" value=''>
        </div>
    </div>
</div>

<div style="height: 7.8em; margin-top: 3.5em; margin-left: -1em; padding-top:0.1em; position: relative;">
    <div id="divprint" class="col-md-5">
        <a id="btnprint" href="{{url('dynamic_pdf/pdf')}}" class="btn btn-danger" tabindex="6" target="_blank"><span class="glyphicon glyphicon-print"></span> Convert to PDF</a>
            
        <a id="btnprint" href="{{url('dynamic_word/wordexport')}}" class="btn btn-danger" tabindex="7" target="_blank"><span class="glyphicon glyphicon-print"></span> Convert to DOC</a>

        <button type="submit" id="btnprintrefresh" class="btn btn-danger" tabindex="8" >
        <span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            
            <input type="hidden" name='hidden_frmdt' id="hidden_frmdt">
            <input type="hidden" name='hidden_todt' id="hidden_todt">
    </div>
    
</div>

