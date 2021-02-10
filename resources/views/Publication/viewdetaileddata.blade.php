@extends('viewdatalayout')

@section('viewcontent')

@include('pubheader')

<form class="my-form" id="view-data-form" autocomplete="off" action="{{ route('viewdata.index') }}" method="GET">

    @csrf

    @foreach($data as $publicationdata)
    
    <div class="main" style="width: 100%;">
        <div class="container-1">
            <div class="headerdetails-1">
                <div class="update-1">
                    <label class="lblindx" >Publication Date:</label>
                    <input type="date" name="viewdatafld" id ="viewdatafld" value="{{ $publicationdata->pubdate }}" tabindex="1" style="pointer-events:none;"/>
                </div>
            </div> <!-- headerdetails-1 -->
            <div class="headerdetails-2">
                <div class="update-1">
                    <label class="lblindx">Author Type:</label>
                    <select class="selectmainpage" name="viewdataauthortype" id="viewdataauthortype" tabindex="2" style="pointer-events:none;">
                        <option value='{{ $publicationdata->authortypeid }}' selected value="{{ $publicationdata->authortypeid }}">{{ $publicationdata->authortype }}</option>
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx">Category:</label>
                    <select class="selectmainpage" name="viewdatacategory" id="viewdatacategory" tabindex="3" style="pointer-events:none;">
                        <option value='{{ $publicationdata->categoryid }}' selected value="{{ $publicationdata->categoryid }}">{{ $publicationdata->category }}</option>
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx">Demography:</label>
                    <select class="selectmainpage" name="viewdatanationality" id="viewdatanationality" tabindex="4" style="pointer-events:none;">
                        @if(is_null($publicationdata->nationality))
                            <option value='0' selected>None</option>
                        @endif

                        @if($publicationdata->nationality == 1)
                            <option value="1">National</option>
                        @endif

                        @if($publicationdata->nationality == 2)
                            <option value="2">International</option>
                        @endif
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx">Type of Conference:</label>
                    <select class="selectmainpage" name="viewdataarticle" id="viewdataarticle" tabindex="5" style="pointer-events:none;">
                        @if(is_null($publicationdata->articletypeid))
                            <option value="0">None</option>
                        else
                            <option value="{{ $publicationdata->articletypeid }}">{{ $publicationdata->article }}</option>
                        @endif
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="ranking">Ranking:</label>
                    <select class="selectmainpage" name="viewdataranking" id="viewdataselranking" tabindex="6" style="pointer-events:none;">
                        @if(is_null($publicationdata->rankingid))
                            <option value="0">None</option>
                        @endif

                        @if(!is_null($publicationdata->rankingid))
                            <option value="{{ $publicationdata->rankingid }}">{{ $publicationdata->ranking }}</option>
                        @endif
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="broadarea">Broad Area:</label>
                    <select class="selectmainpage" name="viewdataselbroadarea" id="viewdataselbroadarea" tabindex="7" style="pointer-events:none;">
                        @if(is_null($publicationdata->broadareaid))
                            <option value="0">None</option>
                        @endif

                        @if(!is_null($publicationdata->broadareaid))
                            <option value="{{ $publicationdata->broadareaid }}">{{ $publicationdata->broadarea }}</option>
                        @endif
                    </select>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="impactfactor">Impact Factor of Journal:</label>
                    <input type="text" class="inputmainpage txtinput" tabindex="8" name="viewdataimpactfactor" id="viewdataimpactfactor" placeholder=" Impact Factor of Journal" value="{{ $publicationdata->impactfactor }}" style="pointer-events:none;"/>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="title">Title of the Paper:</label>
                    <textarea style="pointer-events:none;" class="textareamainapge" name="viewdatatitle" id="viewdatatitle" placeholder=" Title of the Paper" tabindex="9">{{ $publicationdata->title }}</textarea>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="conference">Name of Conference/Journal:</label>
                    <textarea style="pointer-events:none;" name="viewdataconference" class="textareamainapge" id ="viewdataconference" placeholder=" Name of Conference/Journal" tabindex="10">{{ $publicationdata->confname }}</textarea>
                </div>

                <div class="update-1">
                    <label class="lblindx">Location:</label>
                    <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" tabindex="11" name="viewdataplace" id="viewdataplace" placeholder=" City/Country" value="{{ $publicationdata->location }}"/>
                </div>

                <div class="update-1">
                    <label class="lblindx" for="volume">volume No.:</label>
                    <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" tabindex="12" name="viewdatavolume" id="viewdatavolume" placeholder=" volume No." value="{{ $publicationdata->volume }}">
                </div>

                <div class="update-1">
                    <label class="lblindx" for="volume">Issue No.:</label>
                    <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" tabindex="13" name="viewdataissue" id="viewdataissue" placeholder=" Issue No." value="{{ $publicationdata->issue }}">
                </div>

                <div class="update-1">
                    <label class="lblindx" for="pp">Page No.:</label>
                    <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" tabindex="14" name="viewdatapp" id="viewdatapp" placeholder=" Page No." value="{{ $publicationdata->pp }}">
                </div>

            </div><!-- headerdetails-2 -->
        </div><!-- container-1 -->
        
        <div class="container-2">
            <div class="update-1">
                <label class="lblindx" for="digitallibrary">DOI:</label>
                <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" tabindex="15" name="viewdatadigitallibrary" id="viewdatadigitallibrary" placeholder=" DOI" value="{{ $publicationdata->doi }}">
            </div>
            <div class="update-1">
                    <label class="lblindx" for="publisher">Publisher:</label>
                    <input style="pointer-events:none;" type="text" class="inputmainpage txtinput" name="publisher" id="publisher" placeholder=" Publisher" value="{{ $publicationdata->publisher }}">
                </div>
            <br>
            <div class="details">
                <label class="lblindx" for="author" id="lblauthor">Authors (Sl. No. is the First Author): </label>

                <table id="update-author-data" class="author-data">
                    <thead>
                        <tr>
                            <th style="width: 15%">Sl No.</th>
                            <th style="width: 65%">Name</th>
                            <th style="width: 10%; text-align:center; display:none;">Edit</th>
                            <th style="width: 10%; text-align:center; display:none;">Delete</th>
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
                                <td style="text-align:center; display:none;"><img id='imgedit' src="../image/edit-icon.png"></td>
                                <td class="delete-class" style="text-align:center; display:none;"><img class='del-class' id='imgdelete' src="../image/delete-icon.png"></td>
                                <td hidden><input type="text" name="updatefirstname[]" value="{{ $publicationauthordata->firstname }}"></td>
                                <td hidden><input type="text" name="updatemiddlename[]" value="{{ $publicationauthordata->middlename }}"></td>
                                <td hidden><input type="text" name="updatelastname[]" value="{{ $publicationauthordata->lastname }}"></td>
                                <td hidden><input type="text" name="updateslno[]" value="{{ $publicationauthordata->slno }}"></td>
                            </tr>
                        @endforeach    
                    </tbody>
                </table>
            </div> <!-- details-->
        </div><!-- container-2 -->
    </div><!-- main -->

    @endforeach

</form>

@include('pubfooter')

@endsection