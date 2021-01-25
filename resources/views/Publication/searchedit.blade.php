
<input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>

<div class="mainsearch">
    <div class="divsearch-1">
        <div class="divsearch-sub">
            <label class="lblsearch">Publication From Date</label>
            <input class="dtsearch" type="date" name="searchdatefldfrom" id="searchdatefldfrom" tabindex="1">
        </div>

        <div class="divsearch-sub">
            <label class="lblsearch">Publication To Date</label>
            <input class="dtsearch" type="date" name="searchdatefldto" id="searchdatefldto" tabindex="2">
        </div>    

        <div class="divsearch-sub"> 
            <label class="lblsearch">Author Type</label>
            <select class="selectsearch" name="authortypeselect" id="authortypeselect" tabindex="3">
                <option value='0' selected >None</option>
                @foreach($authortypeData['data'] as $authortype)
                    <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                @endforeach
            </select>
        </div>

        <div class="divsearch-sub"> 
            <label class="lblsearch">Category</label>
            <select class="selectsearch" name="categoryselect" id="categoryselect" tabindex="4">
                <option value='0' selected >None</option>
                @foreach($categoryData['data'] as $category)
                    <option value='{{ $category->id }}'>{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="divsearch-sub"> 
            <label class="lblsearch">Demography</label>
            <select class="selectsearch" name="nationalityselect" id="nationalityselect" tabindex="6">
                <option value='0' selected >None</option>
                <option value="1">National</option> 
                <option value="2">International</option>
            </select>
        </div>

        <div class="divsearch-sub">
            <label class="lblsearch">Ranking</label> 
            <div class="multicheck">

            </div>
        </div>

    </div>    
</div> <!-- mainsearch -->
<div class="mainsearch-1">
    <div class="divsearch-3">
        <label class="lblsearch" for="lblsearch">Title of the Paper</label>
        <input type="text" class="inputsearch" name="titlesearch" id="titlesearch" placeholder=" Title of the Paper" tabindex="8">
    </div>

    <div class="divsearch-3">
        <label class="lblsearch" for="lblsearch">Name of Conference/Journal</label>
        <input type="text" class="inputsearch" name="conferencesearch" id="conferencesearch" placeholder=" Name of Conference/Journal" tabindex="9">
    </div>
</div> <!-- mainsearch-1 -->

<div class="mainsearch-1">
    <div style="height: 15em; border:1px solid #ccc; border-radius: 5px; width:67em;">
        <div class="table-structure">
            <input type="text" class="inputsearch" name="authorsearch" id="authorsearch" placeholder=" Author Search" tabindex="11">
        </div>
        <div>
            <table id="auth-edit-header" class="scroll" style="table-layout:fixed;">
                <thead id="search-tablehead">
                    <tr>
                        <th style="text-align: center;">Select</th>  
                        <th>First name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="dynamic_edit_content" style="margin-top: -12px;">   
            <table id="auth-edit-data" class="scroll" style="table-layout:fixed;">
                <tbody id="search-tablebody">
                            
                </tbody>    
            </table>
        </div>
    </div>
</div> <!-- mainsearch-1 -->

<div class="author-search-1">
      <div style="border:1px solid #ccc; border-radius: 5px; padding:5px; position:relative; overflow:auto; 
      height:21.5em; width: 80em;">
        <table id="auth_search_edit" style="width:78em;">
            <thead>    
                <tr>
                    <th style="width: 10em; font-size: .9em;">Date</th>
                    <th style="width: 10em; font-size: .9em;">Author Type</th>
                    <th style="width: 15em; font-size: .9em;">Author</th>
                    <th style="width: 10em; font-size: .9em;">Category</th>
                    <th style="width: 10em; font-size: .9em;">Nationality</th>
                    <th style="width: 10em; font-size: .9em;">Type of Conference</th>
                    <th style="width: 10em; font-size: .9em;">Ranking</th>
                    <th style="width: 10em; font-size: .9em;">Broad Area</th>
                    <th style="width: 10em; font-size: .9em;">Impact Factor</th>
                    <th style="width: 18em; font-size: .9em;">Title</th>
                    <th style="width: 18em; font-size: .9em;">Conference</th>
                    <th style="width: 10em; font-size: .9em;">City/Country</th>
                    <th style="width: 10em; font-size: .9em;">Volume</th>
                    <th style="width: 10em; font-size: .9em;">Issue</th>
                    <th style="width: 10em; font-size: .9em;">Pages</th>
                    <th style="width: 10em; font-size: .9em;">DOI</th>
                    <th class="hidetd" style="width: 4em; font-size: .9em;">Edit</th>
                    <th class="hidetd" style="width: 4em; font-size: .9em;">Delete</th>
                    <th hidden>hdrid</th>
                    <th hidden>userid</th>
                </tr>
            </thead>
            <tbody>

            </tbody>  
        </table>
      </div>
    </div>
</div>  <!--author-search -->

<div style="height:3em; position: relative; left: 0;padding-left: 1px; height: 4.5em; padding-top: .5em;">
    <div id="divsearch" class="col-md-5" style="margin-left:1em;">
        <!-- <button id="btnsearchedit" class="btn btn-danger" tabindex="">Search</button> -->
        <button type="submit" id="btnsearchedit" class="btn btn-danger" tabindex="12" style="outline: none;" >
        <span class="glyphicon glyphicon-search"></span> Search</button>
        
        <!-- <button id="btnprintrefresh" class="btn btn-danger" tabindex="">Refresh</button> -->
        <button id="btnsearchrefresh" class="btn btn-danger" tabindex="13" style="outline: none;" >
        <span class="glyphicon glyphicon-refresh"></span> Refresh</button>
    </div>    
</div>

<div id="myModal1" class="modal">
    <!-- Modal content -->
    <!-- <div class="modal-dialog" id="modaldialog1" role="document"> -->
        <div id="idmodalcontent" class="modal-content">
            <span id="spanclose1" class="closeexpire">&times;</span>
            <label style="font-size: 20px; padding-left: 10px; padding-bottom: 10px; padding-top: 5px;"><strong>The page has been expired.</strong></label>
            <label style="font-size: 15px; color : red; padding-left: 10px; padding-bottom: 10px;"><strong>Please Login again.</strong></label>
        </div>
    <!-- </div> -->
</div>