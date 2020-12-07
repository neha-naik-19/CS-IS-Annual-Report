@extends('loginheader')

@section('logincontent')
<!-- <div id="app"> -->
    <div class="container">
        <div class="login-box">

            <input type="hidden" name="application_url" id="application_url_login" value="{{URL::to(Request::route()->getPrefix())}}"/>

            <form class="email-login" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="anchor-div">
                    <a class="main-anchor" href="/login/google" >
                        <img width="20px" height="30px" style="margin-top:1px; margin-left:2.0em" alt="Google sign-in" 
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                        <strong>Sign in with Google</strong>
                    </a>
                </div>
            </form>

            <div style="margin-top: 1.0em; margin-left: 10.7em;"><strong style="color: #8B0000;">Sign-In with Bits email ID.</strong></div>
        </div>
    </div>  
<!-- </div> -->
@endsection
