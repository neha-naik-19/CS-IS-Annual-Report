<input type="hidden" name="application_url" id="application_url_view" value="{{URL::to(Request::route()->getPrefix())}}"/>

<div class="mainprnt">
    <!-- <div class="divprint-2">
        <label class="lblprint">Date From</label>
        <input class="dtview" type="date" tabindex="1" name="viewdatefldfrom" id="viewdatefldfrom">
        <span id="error-fromdt-view" class="text-danger"></span>
    </div> 

    <div class="divprint-2">
        <label class="lblprint">Date To</label>
        <input class="dtview" type="date" tabindex="2" name="viewdatefldto" id="viewdatefldto">
        <span id="error-todt-view" class="text-danger"></span>
    </div>  -->

    <div class="divprint-2">
        <label class="lblprint">Year From</label>
        <input class="date-own hide-div" tabindex="1" name="viewdatefldfrom" id="viewdatefldfrom" style="width: 150px;" type="text" placeholder="yyyy">
    </div><!-- divprint-2 -->

    <div class="divprint-2">
        <label class="lblprint">Year To</label>
        <input class="date-own hide-div" tabindex="2" name="viewdatefldto" id="viewdatefldto" style="width: 150px;" type="text" placeholder="yyyy">
    </div><!-- divprint-2 -->
    
    <div class="divprint-2">
        <label class="lblprint">Author</label>
        <input type="text" class="inputview" name="author_view_search" id="author_view_search" placeholder=" Author Search" tabindex="3">
    </div> <!-- divprint-2 -->

    <div class="divprint-2">
        <button type="submit" id="btn_view_submit" class="btn btn-danger hide-div" tabindex="4" style="outline: none; position:Absolute; top: 158px; height: 30px;">
        <span class="glyphicon glyphicon-search"></span> Search</button>
    </div> <!-- divprint-2 -->

    <div class="divprint-2">
        <button id="btn_view_refresh" class="btn btn-danger hide-div" tabindex="5" style="outline: none; position:Absolute; top: 158px; height: 30px; right: 290px;">
        <span class="glyphicon glyphicon-search"></span> Refresh</button>
    </div> <!-- divprint-2 -->

    <div id="div_view_author_search" class="hidetd" style="position:Absolute; border: 1px solid #ccc; border-radius: 5px; padding: 2px; height: 100px; width: 340px;float: right;
        top: 192px; right: 480px; background-color: white; z-index: 2; box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);">
        <div id="dynamic_view_content">   
            <table class="viewlist" id="auth-view-data" style="width:700px;">
                <tbody>
                            
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="author-view hide-div" style="height: 450px;">
    <div class="hide-div" style="border:1px solid #ccc; border-radius: 5px; padding:5px; position:Absolute; overflow:auto; 
      height:450px; width: 1150px; bottom: 11px;">

        <table class="hide-div" id="view_auth_details_display" style="width:95%;">
            <thead>
                <tr>
                    <th style="font-size: .9em; width: 12%;">Date</th>
                    <th style="font-size: .9em; width: 25%;">Author</th>
                    <th style="font-size: .9em; width: 25%;">Title</th>
                    <th style="font-size: .9em; width: 30%;">Conference</th>
                    <th style="font-size: .9em; width: 10%; text-align: center;">View</th>
                    <th hidden>pubhdrid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;"><img id="imgview" src="../image/eyeicon.png"></td>
                    <td style="display: none;"></td>
                </tr>
            </tbody>
        </table>
    </div>  
</div>