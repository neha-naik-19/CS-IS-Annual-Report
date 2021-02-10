// var fileTypes = ['pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png', 'txt'];  //acceptable file types
var reader = new FileReader();
let readerdata = '';
var bibtexfile = '';

var checkdup = 0;
var dup_title = [];
var dup_conference = [];

var obj = {};

var url = $('#application_url').val();

var fileTypes = ['bib', 'docx', 'txt'];  //acceptable file types
function readURL(input) {
    if (input.files && input.files[0]) {
        var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types

        // $('#btnsavedata').prop('disabled', true);

        if (isSuccess) { //yes
            reader.onload = function (e) {
                if (extension == 'bib'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136538.svg');
                    $('#btnsavedata').prop('disabled', false);
                }
                else if (extension == 'docx'){  
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/281/281760.svg');
                    $('#btnsavedata').prop('disabled', false);
                }
                else if (extension == 'txt'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136538.svg');
                    $('#btnsavedata').prop('disabled', false);
                }
                else {
                    $(input).closest('.uploadDoc').find(".docErr").slideUp('slow');
                }

                reader.result.toString();

                var rawLog = reader.result;
                readerdata = rawLog;
                console.log(rawLog);

                ////
                
                dup_title = [];
                dup_conference  = [];
                //ajax call to get data in table
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    dataType: 'text',
                    url: url + '/getfiledata',
                    data: {'filedata': reader.result.replace(/^.+?;base64,/, '')},
                    success:function(data)
                    {
                        if(reader.result.length > 0)
                        {
                            checkdup = 1;
                        }
                    },
                    complete:function(){
                        //check duplication
                        $.ajax({
                            url: url + "/checkduplication",
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (key, value) {
                                    obj={
                                        title : value.title,
                                        conference : value.conference
                                      };
                            
                                      dup_title.push(obj.title);
                                      dup_conference.push(obj.conference);

                                    //dup_title = value.title ;
                                    //dup_conference = value.conference ;
                                });
                            }
                        });
                    },
                    error:function(xhr, errorType, exception){
                            console.log(xhr.responseText)
                            console.log('errorType : ' + errorType + " exception : " + exception)
                    }
                });

                // readerdata = reader.result.toString();
            }

            reader.readAsDataURL(input.files[0]);

            // reader.onload = function (e) {
            //     if (extension == 'pdf'){
            //     	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/179/179483.svg');
            //     }
            //     else if (extension == 'docx'){
            //     	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/281/281760.svg');
            //     }
            //     else if (extension == 'rtf'){
            //     	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136539.svg');
            //     }
            //     else if (extension == 'png'){ $(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136523.svg'); 
            //     }
            //     else if (extension == 'jpg' || extension == 'jpeg'){
            //     	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136524.svg');
            //     }
            //   else if (extension == 'txt'){
            //     	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136538.svg');
            //     }
            //     else {
            //     	//console.log('here=>'+$(input).closest('.uploadDoc').length);
            //     	$(input).closest('.uploadDoc').find(".docErr").slideUp('slow');
            //     }
            // }
        }
        else 
        {
        	//console.log('here=>'+$(input).closest('.uploadDoc').find(".docErr").length);
            $(input).closest('.uploadDoc').find(".docErr").fadeIn();
            setTimeout(function() {
				$('.docErr').fadeOut('slow');
			}, 9000);
        }
    }
}

$(document).ready(function(){

    var bibtex_error_check = 1;

    function BibTex_alertbox(title, msg, $true) {
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

    function confirm_bibtex_entry(title, msg, $true, $false) {
        var $content =  "<div class='dialog-ovelay'>" +
                        "<div class='dialog'><header>" +
                        " <h3> " + title + " </h3> " +
                        "<i class='fa fa-close'></i>" +
                            "</header>" +
                            "<div class='dialog-msg'>" +
                                " <p> " + msg + " </p> " +
                            "</div>" +
                            "<footer>" +
                                "<div class='controls'>" +
                                    " <button class='button button-danger doAction'>" + $true + "</button> " +
                                    " <button class='button button-default cancelAction'>" + $false + "</button> " +
                                "</div>" +
                            "</footer>" +
                        "</div>" +
                        "</div>";
        $('body').prepend($content);

        $('.doAction').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                $(this).remove();
            });

            save_bibtex_entry();
        });

        $('.cancelAction, .fa-close').click(function () {
            $(this).parents('.dialog-ovelay').fadeOut(500, function () {
            $(this).remove();
            });

            $(".icon").attr("src","https://image.flaticon.com/icons/svg/136/136549.svg");
            $('#upload').text('Upload document');
            $('#up').val('');
            $('#txtnote').val('');
        });
    }
   
    $(document).on('change','.up', function(){
        bibtexfile = '';   
        var id = $(this).attr('id'); /* gets the filepath and filename from the input */
	    var profilePicValue = $(this).val();
	    var fileNameStart = profilePicValue.lastIndexOf('\\'); /* finds the end of the filepath */
        profilePicValue = profilePicValue.substr(fileNameStart + 1).substring(0,20); /* isolates the filename */
        
        //var profilePicLabelText = $(".upl"); /* finds the label text */
	    if (profilePicValue != '') {
            bibtexfile = profilePicValue;
	   	    //console.log($(this).closest('.fileUpload').find('.upl').length);
	        $(this).closest('.fileUpload').find('.upl').html(profilePicValue); /* changes the label text */
        }
    });


    //$(".btn-new").on('click',function(){
    //  var numItems = $('.uploadDoc').length

    //  if(numItems <= 1)
    //  {
    //     $("#uploader").append('<div class="row uploadDoc"><div class="col-sm-3"><div class="docErr">Please upload valid file</div><!--error--><div class="fileUpload btn btn-orange"> <img src="https://image.flaticon.com/icons/svg/136/136549.svg" class="icon"><span class="upl" id="upload">Upload document</span><input type="file" class="upload up" id="up" onchange="readURL(this);" /></div></div><div class="col-sm-8"><input type="text" class="form-control" name="" placeholder="Note"></div><div class="col-sm-1"><a class="btn-check"><i class="fa fa-times"></i></a></div></div>');
    //  }
    //});
    
    $(document).on("click", "a.btn-check" , function() {
        //  if($(".uploadDoc").length>1){
        //     $(this).closest(".uploadDoc").remove();
        //   }else{
        //     alert("You have to upload at least one document.");
        //   } 

        $(".icon").attr("src","https://image.flaticon.com/icons/svg/136/136549.svg");
        $('#upload').text('Upload document');
        $('#up').val('');
        $('#txtnote').val('');

    });

    // $(document).on("click", "#btnsavedata" , function(e) {
    $('#bibtex-form').on('submit', function(e){
        e.preventDefault();

        var validforupload = 0;
        var authortype = $("#authortypebibtex").val();
        var filedata = $("#up").val();

        if(authortype != 0 && filedata != '')
        {
            validforupload = 1;
        }

        if(validforupload == 0)
        {
            BibTex_alertbox('Alert','Please select Autor Type and Upload the file.','OK');

            return false;
        }

        var message = '';
        var creatediv = '';
        if(dup_title.length > 0 && dup_conference.length > 0)
        {   
            for (i = 0; i < dup_title.length; i++) {
                for (j = i; j < dup_conference.length; j++)
                {
                    if(dup_title[i] != undefined && dup_conference[j] != undefined)
                    {
                        creatediv = (creatediv == '') ? "<div>" +
                                    "Title : <label><strong style='color: #0000FF;'>" + dup_title[i] + "</strong></label><br />" +
                                    "Conference : <label><strong style='color: #0000FF;'>" + dup_conference[j] + "</strong></label>" +
                                    "</div>" : 
                                    creatediv + "<div>" +
                                    "Title : <label><strong style='color: #0000FF;'>" + dup_title[i] + "</strong></label><br />" +
                                    "Conference : <label><strong style='color: #0000FF;'>" + dup_conference[j] + "</strong></label>" +
                                    "</div>";

                    }

                    break;
                }
            }
        }

        if(dup_title.length > 0 && dup_conference.length == 0)
        {
            for (i = 0; i < dup_title.length; i++) {

                if(dup_title[i] != undefined)
                {
                    creatediv = (creatediv == '') ? "<div>" +
                                "Title : <label><strong style='color: #0000FF;'>" + dup_title[i] + "</strong></label></div>" : 
                                creatediv + "<div>" +
                                "Title : <label><strong style='color: #0000FF;'>" + dup_title[i] + "</strong></label><br /></div>";
                }
            }
        }

        if(dup_title.length == 0 && dup_conference.length > 0)
        {
            for (j = 0; j < dup_conference.length; j++)
            {
                if(dup_conference[j] != undefined)
                {   
                    creatediv = (creatediv == '') ? "<div>" +
                                "Conference : <label><strong style='color: #0000FF;'>" + dup_conference[j] + "</strong></label></div>" : 
                                creatediv + "<div>" +
                                "Conference : <label><strong style='color: #0000FF;'>" + dup_conference[j] + "</strong></label><br /></div>";
                }
            }
        }

        if(creatediv != '')
        {
            message = creatediv + "<div> already exist.<br /> Do you still want to continue to save..? </div>";
        }

        if(message != '')
        {
            validforupload = 0;
            confirm_bibtex_entry('Confirm', message, 'Yes', 'No');
        }

        if(validforupload == 1 && message == '')
        {
            save_bibtex_entry();
        }
    });

    $(document).on("click", "#btnresetdata" , function(e) {
        refresh_bibtex();
    });

    //save data in database
    var savedsuccessfully = 0;

    function save_bibtex_entry()
    {
        var authortype = $("#authortypebibtex").val();
        var note = $('#txtnote').val();
        bibtex_error_check = 1;

        if(reader.result.replace(/^.+?;base64,/, '') != '')
        {
            //ajax call for data save
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'text',
                url: url + '/readbibtex',
                // data: $('#bibtex-form').serialize(),
                data: {'filedata': reader.result.replace(/^.+?;base64,/, ''),'authortype':authortype, 'note':note, 'bibtexfile': bibtexfile},
                beforeSend:function()
                {
                    var percentage = 0;

                    var timer = setInterval(function(){
                        percentage = percentage + 20;

                        progress_bar_process(percentage, timer);
                    }, 500);
                },
                success:function(data)
                {
                    console.log('SUCCESS: ', 'Saved Successfully!!!');


                    savedsuccessfully = 1;


                    $('#btnsavedata').attr('disabled','disabled');
                    $('#btnresetdata').attr('disabled','disabled');
                    $('#process').removeClass("hidetd")
                    disablemainbuttons();
                },

                error:function(xhr, errorType, exception){
                        console.log(xhr.responseText)
                        console.log('errorType : ' + errorType + " exception : " + exception)

                        alert(xhr.responseText);

                    // if(xhr.status == 419)
                    // {
                    //     $("#myModal_bibtex").css("display", "block");
                    // }
                    // else
                    // {
                    //     alert(xhr.responseText);
                    // }

                    if(xhr.status == 419)
                    {
                        bibtex_error_check = 0;

                        $('#spnexpire').removeClass("hidetd");

                        setTimeout(function(){
                            $('#spnexpire').addClass("hidetd");
                        }, 3000 );
                    }

                    if(bibtex_error_check == 0){bibtex_error_check = 1;}
                }
            });
        }
        else
        {
            $('#spnempty').removeClass("hidetd");
            $(".icon").attr("src","https://image.flaticon.com/icons/svg/136/136549.svg");
            $('#upload').text('Upload document');
            $('#up').val('');

            setTimeout(function(){
                $('#spnempty').addClass("hidetd");
            }, 2000 );
        }
    }

   //Progress Bar should show progress ( percent by percent ) with the insertion of data into database
    function progress_bar_process(percentage, timer){
        $('.progress-bar').css('width', percentage + '%');

        if(percentage > 100)
        {
            clearInterval(timer);
            $('#process').addClass("hidetd");
            $('.progress-bar').css('width','0%');

            $('#bibtex-form')[0].reset();
            $(".icon").attr("src","https://image.flaticon.com/icons/svg/136/136549.svg");
            $('#upload').text('Upload document');
            $('#up').val('');

            $('#btnsavedata').attr('disabled',false);
            $('#btnresetdata').attr('disabled',false);

            enablemainbuttons();

            if(savedsuccessfully == 1)
            {
                $('#spnsuccess').removeClass("hidetd");

                setTimeout(function(){
                    $('#spnsuccess').addClass("hidetd");
                }, 1500 );
            }
            else{
                if(bibtex_error_check == 1)
                {
                    $('#spnerror').removeClass("hidetd");

                    setTimeout(function(){
                        $('#spnerror').addClass("hidetd");
                    }, 2000 );
                }
            }

        }
    }
});