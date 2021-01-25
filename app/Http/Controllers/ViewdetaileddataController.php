<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

use App\Models\categories;
use App\Models\authortypes;
use App\Models\rankings;
use App\Models\broadareas;
use App\Models\impactfactors;
use App\Models\pubhdr;
use App\Models\pubdtl;
use App\Models\articletypes;
use App\Models\pubuserdetails;
use App\Models\User;

class ViewdetaileddataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $headerid = base64_decode($id);

        $data =  DB::select('call Get_update_Data (?)',array($headerid));

        $authordata =  DB::select('call Get_Author_Data_For_Update (?)',array($headerid));
                      

        return view('Publication.viewdetaileddata')->with('data',$data)->with('authordata',$authordata);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
