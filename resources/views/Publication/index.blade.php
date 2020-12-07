@extends('publayout')

@section('maincontent')

@include('pubheader')

    <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>

    <form class="my-form" id="main-form" autocomplete="off" method="POST" action="{{ route('publication.store') }}" >

        @csrf

        <div class="required-message" id="required-message" style="display:none;">
            <ul class="ul-required-message"></ul>
        </div>

        <div class="main" style="width: 100%;">
            <div class="container-1">
                <input type="hidden" id="hdnsel" name="hdnsel" value="0">
                
                <div class="headerdetails-1">
                    <div class="div-1">
                        <label class="lblindx" >Publication Date:</label>
                        <input type="date" tabindex="1" name="datefld" id ="datefld" />
                        <!-- value="<?php echo date("Y-m-d"); ?>" -->
                        <span id="dterror" class="text-danger"></span>	
                    </div>
                </div> <!-- headerdetails-1 -->

                <div class="headerdetails-2">
                    <div class="div-1">
                        <label class="lblindx">Author Type:</label>
                        <select class="selectmainpage" name="authortype" id="authortype" tabindex="2" >
                            <option value='0' disabled selected>Select</option>
                            @foreach($authortypeData['data'] as $authortype)
                                <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                            @endforeach
                        </select>
                        <span id="error-authortype" class="text-danger"></span>
                    </div>
                    <div class="div-1">
                        <label class="lblindx">Category:</label>
                        <select class="selectmainpage" name="category" id="category" tabindex="3">
                            <option value='0' disabled selected>Select</option>
                            @foreach($categoryData['data'] as $category)
                                <option value='{{ $category->id }}'>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <span id="error-category" class="text-danger"></span>
                    </div>

                    <div class="div-1"> 
                        <label class="lblindx">Demography:</label>
                        <select class="selectsearch" name="nationality" id="nationality" tabindex="4">
                            <option value='0' selected>None</option>
                            <option value="1">National</option> 
                            <option value="2">International</option>
                        </select>
                        <span id="error-nationality" class="text-danger"></span>
                    </div>

                    <div class="div-1">
                        <label class="lblindx">Type of Conference:</label>
                        <select class="selectmainpage" name="article" id="article" tabindex="6">
                            <option value='0' selected>None</option>
                        </select>
                    </div>

                    <div class="div-1">
                        <label class="lblindx" for="ranking">Ranking:</label>
                        <select class="selectmainpage" name="ranking" id="selranking" tabindex="7">
                            <option value='0' selected>None</option>
                            @foreach($rankingsData['data'] as $ranking)
                                <option value='{{ $ranking->id }}'>{{ $ranking->ranking }}</option>
                            @endforeach
                        </select>
                        <a class="img-add" id="ranking" data-target="#modalranking"><img src="../image/add-popup.png"></a>
                    </div>
     
                    <div class="div-1">
                        <label class="lblindx" for="broadarea">Broad Area:</label>
                        <select class="selectmainpage" name="broadarea" id="selbroadarea" tabindex="8">
                            <option value='0' selected>None</option>
                            @foreach($broadareasData['data'] as $broadarea)
                                <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>
                            @endforeach
                        </select>
                        <a class="img-add" id="broadarea" data-target="#modalbroadarea"><img src="../image/add-popup.png"></a>
                    </div>
                 
                    <div class="div-1">
                        <label class="lblindx" for="impactfactor">Impact Factor of Journal:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="9" name="impactfactor" id="impactfactor" placeholder=" Impact Factor of Journal" />
                    </div>
                
                    <div class="div-1">
                        <label class="lblindx" for="title">Title of the Paper:</label>
                        <textarea name="title" class="textareamainapge" id="title" placeholder=" Title of the Paper" tabindex="10"></textarea>
                        <span id="error-title" class="text-danger"></span>
                    </div>

                    <div class="div-1">
                        <label class="lblindx" for="conference">Name of Conference/Journal:</label>
                        <textarea name="conference" class="textareamainapge" id ="conference" placeholder=" Name of Conference/Journal" tabindex="11"></textarea>
                        <span id="error-conference" class="text-danger"></span>
                    </div>

                    <div class="div-1">
                        <label class="lblindx">Location:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="12" name="place" id="place" placeholder=" City/Country" />
                        <span id="error-place" class="text-danger"></span>
                    </div>

                    <div class="div-1">
                        <label class="lblindx" for="volume">Volume No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="13" name="volume" id="volume" placeholder=" Volume No.">
                    </div>

                    <div class="div-1">
                        <label class="lblindx" for="volume">Issue No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="14" name="issue" id="issue" placeholder=" Issue No.">
                    </div>

                    <div class="div-1">
                        <label class="lblindx" for="pp">Page No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="15" name="pp" id="pp" placeholder=" Page No.">
                    </div>
                </div> <!-- headerdetails-2 -->
            </div> <!-- container-1 -->

            <div class="container-2">
                <div class="div-1">
                    <label class="lblindx" for="digitallibrary">DOI:</label>
                    <input type="text" class="inputmainpage txtinput" tabindex="16" name="digitallibrary" id="digitallibrary" placeholder=" DOI">
                </div>

                <div class="details">
                    <label class="lblindx" for="author" id="lblauthor">Authors (Sl. No. is the First Author): </label>

                    <input type="hidden" id="hdninput" name="hdninput" value="0">
                    <input type="hidden" id="hdnrindex" name="hdnrindex" value="0">
                    
                    <input type="text" id="firstname" name="firstname" placeholder=" First Name" tabindex="17" onkeyup="disableinputs()">

                    <input type="text" id="middlename" name="middlename" placeholder=" Middle Name" tabindex="18" onkeyup="disableinputs()">

                    <input type="text" id="lastname" name="lastname" placeholder=" Last Name" tabindex="19" onkeyup="disableinputs()">

                    <input type="text" id="slno" name="slno" style="display: none">

                    <input type="text" id="checkauthorentry" name="checkauthorentry" style="display: none">

                    <button id="btnadd" disabled onclick="AddAuthor(event)"><img src="../image/Add-icon-button-small.png" tabindex="20"></button>
                    
                    <button id="btnrefresh" onclick="refresh(event)"><img src="../image/refresh-icon.png" tabindex="21"></button>

                    <table id="author-data" class="author-data">
                        <thead>
                            <tr>
                                <th style="width: 15%">Sl No.</th>
                                <th style="width: 65%">Name</th>
                                <th style="width: 10%; text-align:center">Edit</th>
                                <th style="width: 10%; text-align:center">Delete</th>
                                <th hidden>fname</th>
                                <th hidden>mname</th>
                                <th hidden>lname</th>
                            </tr>
                        </thead>
                        <tbody id="my-tablebody">
                            <tr>
                                <td id="slno"></td>
                                <td></td>
                                <td style="text-align:center;"><img src="../image/edit-icon.png"></td>
                                <td class="delete-class" style="text-align:center;"><img src="../image/delete-icon.png"></td>
                                <td hidden></td>
                                <td hidden></td>
                                <td hidden></td>
                            </tr>
                        </tbody>
                    </table>
                    <div>
                        <span id="error-author" class="text-danger"></span>
                    </div>
                    <div>
                        <span id="error-author-name" class="text-danger"></span>
                    </div>
                    <div class="pagination-container">
                        <nav>
                            <ul class="pagination" id="ulpagination">
                                
                            </ul>
                        </nav>
                    </div>
                </div> <!-- details-->
                <div id="submit-button" class="submit-button">
                    <button type="submit" id="btnsubmit" class="btn btn-danger" tabindex="22" style="outline: none;">
                    <span class="glyphicon glyphicon-save"></span>
                    Save</button>

                    <button type="submit" id="pagereset" class="btn btn-danger" tabindex="23" style="outline: none;">
                    <span class="glyphicon glyphicon-refresh"></span>
                    Refresh</button>
                </div>
            </div> <!-- container-2 --> 
        </div> <!-- main -->
    </form>

    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span id="spanclose" class="close">&times;</span>
            <label style="font-size: 20px;"><strong>The page has been expired.</strong></label>
            <label style="font-size: 15px; color : red;"><strong>Please Login again.</strong></label>
        </div>
    </div>

@include('pubfooter')

<!-- Modal Popup -->
<div class="modal fade" id="modalpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" arial-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div id="div_message" class="text_message">
                <span>Request Saved Successfully.</span>
            </div>
            <form action="{{ route('publication.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" name="hdnfld" id="hdnfld" value=''>
                    <input type="text" name="txtpopup" id="txtpopup" class="form-control" placeholder=" Ranking">
                    <span id="error-popup" class="text-danger"></span>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="popupsave" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection

@section('printcontent')
@include('pubheader')
    <div>
        <form id="print-form" autocomplete="off" action="{{ route('print.index') }}" method="POST">
            @csrf
            <div class="printclass">
                @include('Publication.print')
            </div>
        </form>
    </div>
@include('pubfooter')
@endsection

@section('searcheditcontent')
@include('pubheader')
    <div>
        <form id="searchedit-form" autocomplete="off" action="{{ route('searchedit.index') }}" method="POST">
            @csrf
            <div class="searcheditclass">
                @include('Publication.searchedit')
            </div>
        </form>
    </div>
    @include('pubfooter')    
@endsection 




