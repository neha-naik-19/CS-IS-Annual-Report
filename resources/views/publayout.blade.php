<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset = "UTF-8" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->

    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script> -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../css/projectstyle.css">

    <script src="{{ asset('js/basicjs.js') }}" defer></script>
    <script src="{{ asset('js/printjs.js') }}" defer></script>
    <script src="{{ asset('js/searcheditjs.js') }}" defer></script>
    <script src="{{ asset('js/editjs.js') }}" defer></script>
    <script src="{{ asset('js/viewjs.js') }}" defer></script>
    <script src="{{ asset('js/bibtextjs.js') }}" defer></script>

    <title>Annual Report</title>
  </head>
  <body>
    <div class="container-fluid">
        <header>
          <div class="goacampus" style="width: 100%; height: 100%; margin-bottom:.5em; margin-top:.5em;">
            <div>
              <!-- <img src="../image/Bits_logo_1809.png"> -->
              <img src="../image/Bits_logo_Annual_report.png">
            </div>

            <div style="position: absolute; right: 7.0em; top: 1em;">
                <strong style="color: #00008B;">{{ Auth::user()->name }}</strong>
            </div>
            
            <div style="position: absolute; right: 2.1em; top: 2.7em;">
                <a id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->email }}
                </a>
            </div>

            <div id="btnlogout" style="position: absolute; right: 2.1em; top: 3.9em;">
                  <a style="color: red;" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                      [ {{ __('Logout') }} ]
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
            </div>

            <div style="position: absolute; right: 2em; top: 7em;">
              <a id="anrhome" style="border: 1px solid #CCCCCC; padding: 7px; text-decoration: none; 
                          border-radius: 14px; background: #4479BA; color: white; box-shadow: 0 1px 1px #888888;" 
                    href="{{url('/home')}}"><span class="glyphicon glyphicon-home"></span> HOME
              </a>
            </div>
            
            <div style="position:Absolute; float: right; right: 35.6em; top:7.2em;">
              <div class="tabheading">Publication > New</div>
            </div>
            <div style="position:Absolute; float: right; right: 1.0em; top:9.2em;">
              <img src="../image/bits-line.gif">
            </div>
          </div>
        </header>

        <div style="position:Absolute; float: left; width: 106em; border: 1px solid #00008B; height: 3.2px; background-color: #00008B;"></div>

        <div class="layoutmain" > 
          <div class="tab" >
            <a href="#new" style="text-decoration:none"><button id="defaultopen" class="tablinks" onclick="openTab(event,'newentry')" >New</button></a>
            <a href="#new" style="text-decoration:none"><button id="btnview" class="tablinks" onclick="openTab(event,'viewentry')" >View</button></a>
            <a href="#edit" style="text-decoration:none"><button id="btnsearch" class="tablinks" onclick="openTab(event,'searchedit')">Edit</button></a>
            <a href="#print" style="text-decoration:none"><button id="btnprint" class="tablinks" onclick="openTab(event,'printpdf')">Print</button></a>
            <a href="#bibtex" style="text-decoration:none"><button id="btnbibtex" class="tablinks" onclick="openTab(event,'bibtex')">BibTex</button></a>
          </div>

          <div class="maincontent">
            <div class="tabcontent" id="newentry">
              @yield('maincontent')
            </div>

            <div class="tabcontent" id="viewentry">
              @yield('viewcontent')
            </div>

            <div class="tabcontent" id="printpdf">
              @yield('printcontent')
            </div>

            <div class="tabcontent" id="bibtex">
              @yield('bibtexcontent')
            </div> 

            <div class="tabcontent" id="searchedit">
              @yield('searcheditcontent')
            </div> 
          </div>
        </div>
    </div>
  </body>
  
</html>