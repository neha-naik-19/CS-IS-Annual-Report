<div style="height: 510px; overflow: auto,overflow-x: hidden;">
    <div class="container">
        <div class="row it">
            <div class="col-sm-offset-1 col-sm-10" id="one">
                <p>
                Please upload documents only in 'bib', 'docx', & 'text' format.
                </p>

                <div class="mainbibtex">
                    <div class="divprint-2"> 
                        <label class="lblsearch">Author Type</label>
                        <select class="selectsearch" name="authortypebibtex" id="authortypebibtex">
                            <option value='0' selected >None</option>
                            @foreach($authortypeData['data'] as $authortype)
                                <option value='{{ $authortype->id }}'>{{ $authortype->authortype }}</option>
                            @endforeach
                        </select>
                    </div> <!-- divprint-2 -->
                </div><!-- mainprnt -->

                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4 form-group">
                        <h3 class="text-center"></h3>
                    </div><!--form-group-->
                </div><!--row-->

                <div id="uploader">
                    <div class="row uploadDoc">
                        <div class="col-sm-3">
                            <div class="docErr">Please upload valid file</div><!--error-->
                            
                            <div class="fileUpload btn btn-orange">
                                <img src="https://image.flaticon.com/icons/svg/136/136549.svg" class="icon" id="uploadimg">
                                <span class="upl" id="upload">Upload document</span>
                                <input type="file" class="upload up" id="up" onchange="readURL(this);" />
                            
                            </div><!-- btn-orange -->
                        </div><!-- col-3 -->
                        
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="txtnote" name="txtnote" placeholder="Note">
                        </div><!--col-8-->

                        <div class="col-sm-1"><a class="btn-check"><i class="fa fa-times"></i></a></div><!-- col-1 -->
                    </div><!--row-->
                </div><!--uploader-->

                <div class="form-group hidetd" id="process">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" ></div>
                    </div>
                    <span>Please wait until current processing is complete....</span>
                </div>
                <span id="spnsuccess" style="color: Green; margin-left: 10px;" class="hidetd"><strong>Request Saved Successfully.</strong></span>
                <span id="spnerror" style="color: Red; margin-left: 10px;" class="hidetd"><strong>There is an error in saving. Please check..</strong></span>
                <span id="spnexpire" style="color: Red; margin-left: 10px;" class="hidetd"><strong style='fint-size: 18px;'>The page has been expired. Please Login again..</strong></span>
                <span id="spnempty" style="color: Red; margin-left: 10px;" class="hidetd"><strong>No data to upload. Please check..</strong></span>

                <div class="text-center">
                    <a class="btn btn-new" style="display: none;"><i class="fa fa-plus"></i> Add new</a>
                    <a style="display: none;" class="btn btn-next"><i class="fa fa-paper-plane"></i> Submit</a>

                    <button type="submit" id="btnsavedata" class="btn btn-next" ><i class="fa fa-paper-plane"></i> Submit</button>
                    <button type="reset" id="btnresetdata" class="btn btn-new"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
            </div><!--one-->
        </div><!-- row -->
    </div> <!-- container -->
</div>
