@extends('updatelayout')

@section('updatecontent')

@include('pubheader')

    <input type="hidden" name="application_url" id="application_url" value="{{URL::to(Request::route()->getPrefix())}}"/>

    <form class="my-form" id="update-form" autocomplete="off" method="POST" action="{{ route('updatedata.index') }}" >

        @csrf

        <div class="update-required-message" id="update-required-message" style="display:none;">
            <ul class="ul-update-required-message"></ul>
        </div>

        @foreach($data as $publicationdata)

        <div class="main" style="width: 100%;">
            <div class="container-1">
                <input type="hidden" id="hdnheaderid" name="hdnheaderid" value="{{ $publicationdata->id }}">
                
                <div class="headerdetails-1">
                    <div class="update-1">
                        <label class="lblindx" >Publication Date:</label>
                        <input type="date" name="updatedatefld" id ="updatedatefld" value="{{ $publicationdata->pubdate }}" tabindex="1"/>
                        <span id="updatedterror" class="text-danger"></span>	
                    </div>
                </div> <!-- headerdetails-1 -->
                <div class="headerdetails-2">
                    <div class="update-1">
                        <label class="lblindx">Author Type:</label>
                        <select class="selectmainpage" name="updateauthortype" id="updateauthortype" tabindex="2" >
                            <option value='{{ $publicationdata->authortypeid }}' selected value="{{ $publicationdata->authortypeid }}">{{ $publicationdata->authortype }}</option>
                            @foreach($authortypeData['data'] as $authortype)
                                @if($publicationdata->authortypeid != $authortype->id)
                                    <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="update-1">
                        <label class="lblindx">Category:</label>
                        <select class="selectmainpage" name="updatecategory" id="updatecategory" tabindex="3">
                            <option value='{{ $publicationdata->categoryid }}' selected value="{{ $publicationdata->categoryid }}">{{ $publicationdata->category }}</option>
                            @foreach($categoryData['data'] as $category)
                                @if($publicationdata->categoryid != $category->id)
                                    <option value='{{ $category->id }}'>{{ $category->category }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>    

                    <div class="update-1">
                        <label class="lblindx">Demography:</label>
                        <select class="selectmainpage" name="updatenationality" id="updatenationality" tabindex="4">
                            @if(is_null($publicationdata->nationality))
                                <option value='0' selected>None</option>
                                <option value="1">National</option>
                                <option value="2">International</option> 
                            @else
                                @if($publicationdata->nationality =='1')
                                    <option value='1' selected>National</option>
                                    <option value='0'>None</option>
                                    <option value="2">International</option>
                                @endif
                                @if($publicationdata->nationality =='2')
                                    <option value='2' selected>International</option>
                                    <option value='0'>None</option>
                                    <option value="1">National</option>
                                @endif
                            @endif
                        </select>
                        <span id="errorupdate-nationality" class="text-danger"></span>
                    </div>
                        
                    <div class="update-1">
                        <label class="lblindx">Type of Conference:</label>
                        <select class="selectmainpage" name="updatearticle" id="updatearticle" tabindex="5">
                            @if(is_null($publicationdata->articletypeid))
                                <option value='0' selected>None</option>
                                @foreach($articletypeData['data'] as $article)
                                    <option value='{{ $article->articleid }}'>{{ $article->article }}</option>        
                                @endforeach
                            @else
                                <option value='{{ $publicationdata->articletypeid }}' selected>{{ $publicationdata->article }}</option>
                                <option value='0'>None</option>
                                @foreach($articletypeData['data'] as $article)
                                    @if($publicationdata->articletypeid != $article->articleid)
                                        <option value='{{ $article->articleid }}'>{{ $article->article }}</option>
                                    @endif 
                                @endforeach 
                            @endif      
                        </select>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="ranking">Ranking:</label>
                        <select class="selectmainpage" name="updateranking" id="updateselranking" tabindex="6">
                            @if(is_null($publicationdata->rankingid))
                                <option value='0' selected>None</option>
                                @foreach($rankingsData['data'] as $ranking)
                                    <option value='{{ $ranking->id }}'>{{ $ranking->ranking }}</option>        
                                @endforeach
                            @else
                                <option value='{{ $publicationdata->rankingid }}' selected>{{ $publicationdata->ranking }}</option>
                                <option value='0'>None</option>
                                @foreach($rankingsData['data'] as $ranking)
                                    @if($publicationdata->rankingid != $ranking->id)
                                        <option value='{{ $ranking->id }}'>{{ $ranking->ranking }}</option>
                                    @endif 
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="broadarea">Broad Area:</label>
                        <select class="selectmainpage" name="updateselbroadarea" id="updateselbroadarea" tabindex="7">
                            @if(is_null($publicationdata->broadareaid))
                                <option value='0' selected>None</option>
                                @foreach($broadareasData['data'] as $broadarea)
                                    <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>        
                                @endforeach
                            @else
                                <option value='{{ $publicationdata->broadareaid }}' selected>{{ $publicationdata->broadarea }}</option>
                                <option value='0'>None</option>
                                @foreach($broadareasData['data'] as $broadarea)
                                    @if($publicationdata->broadareaid != $broadarea->id)
                                        <option value='{{ $broadarea->id }}'>{{ $broadarea->broadarea }}</option>
                                    @endif 
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="impactfactor">Impact Factor of Journal:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="8" name="updateimpactfactor" id="updateimpactfactor" placeholder=" Impact Factor of Journal" value="{{ $publicationdata->impactfactor }}"/>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="title">Title of the Paper:</label>
                        <textarea class="textareamainapge" name="updatetitle" id="updatetitle" placeholder=" Title of the Paper" tabindex="9">{{ $publicationdata->title }}</textarea>
                        <span id="errorupdate-title" class="text-danger"></span>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="conference">Name of Conference/Journal:</label>
                        <textarea name="updateconference" class="textareamainapge" id ="updateconference" placeholder=" Name of Conference/Journal" tabindex="10">{{ $publicationdata->confname }}</textarea>
                        <span id="errorupdate-conference" class="text-danger"></span>
                    </div>

                    <div class="update-1">
                        <label class="lblindx">Location:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="11" name="updateplace" id="updateplace" placeholder=" City/Country" value="{{ $publicationdata->location }}"/>
                        <span id="errorupdate-place" class="text-danger"></span>
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="volume">volume No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="12" name="updatevolume" id="updatevolume" placeholder=" volume No." value="{{ $publicationdata->volume }}">
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="volume">Issue No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="13" name="updateissue" id="updateissue" placeholder=" Issue No." value="{{ $publicationdata->issue }}">
                    </div>

                    <div class="update-1">
                        <label class="lblindx" for="pp">Page No.:</label>
                        <input type="text" class="inputmainpage txtinput" tabindex="14" name="updatepp" id="updatepp" placeholder=" Page No." value="{{ $publicationdata->pp }}">
                    </div>
                </div> <!-- headerdetails-2 -->
            </div> <!-- container-1 -->
            <div class="container-2">
                <div class="update-1">
                    <label class="lblindx" for="digitallibrary">DOI:</label>
                    <input type="text" class="inputmainpage txtinput" tabindex="15" name="updatedigitallibrary" id="updatedigitallibrary" placeholder=" DOI" value="{{ $publicationdata->doi }}">
                </div>

                <div class="details">
                    <label class="lblindx" for="author" id="lblauthor">Authors (Sl. No. is the First Author): </label>

                    <input type="hidden" id="hdnupdateinput" name="hdnupdateinput" value="0">
                    <input type="hidden" id="hdnupdaterindex" name="hdnupdaterindex" value="0">
                    
                    <input type="text" id="updatefirstname" name="updatefirstname" placeholder=" First Name" tabindex="16" onkeyup="disableupdateinputs()">

                    <input type="text" id="updatemiddlename" name="updatemiddlename" placeholder=" Middle Name" tabindex="17" onkeyup="disableupdateinputs()">

                    <input type="text" id="updatelastname" name="updatelastname" placeholder=" Last Name" tabindex="18" onkeyup="disableupdateinputs()">

                    <input type="text" id="updateslno" name="slno" style="display: none">

                    <input type="text" id="updatecheckauthorentry" name="updatecheckauthorentry" style="display: none">

                    <button id="btnupdateadd" disabled onclick="AddUpdateAuthor(event)"><img src="../image/Add-icon-button-small.png" tabindex="19"></button>
                    
                    <button id="btnupdaterefresh" onclick="refreshupdate(event)"><img src="../image/refresh-icon.png" tabindex="20"></button>

                    <table id="update-author-data" class="author-data">
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
                        <tbody id="update-my-tablebody">
                            @foreach($authordata as $publicationauthordata)
                                <tr>
                                    <td id="slno" style="text-align: center;">{{ $publicationauthordata->slno }}.</td>
                                    <td style="padding-left: 10px;">{{ $publicationauthordata->fullname }}</td>
                                    <td style="text-align:center;"><img id='imgedit' src="../image/edit-icon.png"></td>
                                    <td class="delete-class" style="text-align:center;"><img class='del-class' id='imgdelete' src="../image/delete-icon.png"></td>
                                    <td hidden><input type="text" name="updatefirstname[]" value="{{ $publicationauthordata->firstname }}"></td>
                                    <td hidden><input type="text" name="updatemiddlename[]" value="{{ $publicationauthordata->middlename }}"></td>
                                    <td hidden><input type="text" name="updatelastname[]" value="{{ $publicationauthordata->lastname }}"></td>
                                    <td hidden><input type="text" name="updateslno[]" value="{{ $publicationauthordata->slno }}"></td>
                                </tr>
                            @endforeach    
                        </tbody>
                    </table>
                    <span id="update-error-author" class="text-danger"></span>
                </div> <!-- details-->
                <div id="update-button" class="submit-button">
                    <button type="submit" id="btnupdate" class="btn btn-danger" tabindex="21" style="outline: none;">
                    <span class="glyphicon glyphicon-edit"></span>
                    Update</button>   
                </div>  
            </div>
            <input type="hidden" id="hdnupdatecategory" name="hdnupdatecategory" value="0">
            <input type="hidden" id="hdncheckcategory" name="hdnupdatecategory" value="0">
        </div> <!-- main -->

        @endforeach

    </form>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span id="spanclose" class="close">&times;</span>
            <label style="font-size: 20px;"><strong>The page has been expired.</strong></label>
            <label style="font-size: 15px; color : red;"><strong>Please Login again.</strong></label>
        </div>
    </div>

@include('pubfooter')

@endsection



