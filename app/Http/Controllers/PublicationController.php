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
use App\Models\pubhdr;
use App\Models\pubdtl;
use App\Models\articletypes;
use App\Models\User;

class PublicationController extends Controller
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
    public function index()
    {
        try
        {
            //Date Format
            date_default_timezone_set("Asia/kolkata");

            // Fetch Categories
            $categoryData['data'] = categories::orderby("category","asc")
                                    ->select('id','category')
                                    ->get();

            // Fetch AuthorTypes
            $authortypeData['data'] = authortypes::orderby("authortype","asc")
                                    ->select('id','authortype')
                                    ->get();

            // Fetch only Rankings -> Others
            $rankingsOnlyAstarData = rankings::select('id','ranking')
                                    ->where('ranking','=','Core A*')
                                    ->get();                        
                                    
            // Fetch w/o Rankings -> Others
            $rankingsNoOthersData = rankings::orderby("ranking","asc")
                                    ->select('id','ranking')
                                    ->whereNotIn('ranking', ['Core A*','Others'])
                                    ->get();                         

            // Fetch only Rankings -> Others
            $rankingsOnlyOthersData = rankings::select('id','ranking')
                                    ->where('ranking','=','Others')
                                    ->get();

            //Fetch all rankings in
            $rankingsData['data'] = $rankingsOnlyAstarData->merge($rankingsNoOthersData)->merge($rankingsOnlyOthersData);

            //Fetch Broadareas
            $broadareasData['data'] = broadareas::orderby("broadarea","asc")
                                    ->select('id','broadarea')
                                    ->get();                      
        
            // Load index view
            return view('Publication.index')->with("categoryData",$categoryData)->with('authortypeData', $authortypeData)->with('rankingsData', $rankingsData)
            ->with('broadareasData', $broadareasData);
        }
        catch   (Exception $ex)
        {
            dd('Exception block', $ex);
        }
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
        DB::beginTransaction();
        try
        {
            if($request->hdnfld == 'rn')
            {
                //$ranking = rankings::all();
                $ranking = new rankings();
    
                $ranking->ranking = $request->txtpopupvalue;
                $ranking->save();
            }
            elseif($request->hdnfld == 're')
            {
                $ranking = new rankings();
                $data = rankings::whereId($request->txtpopupeditid)->first();

                $data->update([ //updateing to Rankings table
                    'ranking'      => $request->txtpopupvalue
                ]);
            }
            else if($request->hdnfld == 'bn') //Broad Area
            {
                $broadarea = new broadareas();
    
                $broadarea->broadarea = $request->txtpopupvalue;
                $broadarea->save();
            }
            elseif($request->hdnfld == 'be')
            {
                $ranking = new broadareas();
                $data = broadareas::whereId($request->txtpopupeditid)->first();

                $data->update([ //updateing to Rankings table
                    'broadarea'      => $request->txtpopupvalue
                ]);
            }

            else //main page saving
            {
                if($request->ajax())
                {
                    // json_decode($request);

                    $userid = User::where('email',Auth::user()->email)
                            ->first()->id;
    
                    $pubhdr = new pubhdr();
                    $pubhdr->authortypeid = $request->authortype;
                    $pubhdr->categoryid = $request->category;
                    if($request->nationality == "1"){
                        $pubhdr->nationality = 1;
                    }
                    elseif($request->nationality == "2"){
                        $pubhdr->nationality = 2;
                    }
                    else{
                        $pubhdr->nationality = null;
                    }

                    //Ranking
                    if($request->ranking == 0){
                        $ranking = null;
                    }
                    elseif($request->ranking == null){
                        $ranking = null;
                    }
                    else{
                        $ranking = $request->ranking;
                    }

                    //BroadArea
                    if($request->broadarea == 0){
                        $broadarea = null;
                    }
                    elseif($request->broadarea == null){
                        $broadarea = null;
                    }
                    else{
                        $broadarea = $request->broadarea;
                    }

                    //ImpactFactor
                    if($request->impactfactor == 0){
                        $impactfactor = null;
                    }
                    elseif($request->impactfactor == null){
                        $impactfactor = null;
                    }
                    else{
                        $impactfactor = $request->impactfactor;
                    }

                    //Article
                    if($request->article == 0){
                        $article = null;
                    }
                    elseif($request->article == null){
                        $article = null;
                    }
                    else{
                        $article = $request->article;
                    }

                    $pubhdr->broadareaid = $broadarea;
                    $pubhdr->impactfactor = $impactfactor;
                    $pubhdr->rankingid = $ranking;
                    $pubhdr->confname = ($request->conference != null) ? $request->conference : null;
                    $pubhdr->description = ($request->description != null) ? $request->description : null;
                    $pubhdr->place = $request->place;
                    $pubhdr->pubdate = $request->datefld;
                    $pubhdr->title = ($request->title != null) ? $request->title : null;
                    $pubhdr->articletypeid = $article;
                    $pubhdr->volume = ($request->volume != null) ? $request->volume : null;
                    $pubhdr->issue = ($request->issue != null) ? $request->issue : null;
                    $pubhdr->pp = ($request->pp != null) ? $request->pp : null;
                    $pubhdr->digitallibrary = ($request->digitallibrary != null) ? $request->digitallibrary : null;
                    $pubhdr->publisher = $request->publisher;
                    $pubhdr->userid = $userid;
                    $pubhdr->deleted  = 0;
                    $pubhdr->created_at = Carbon::now();
                    
                    $pubhdr->save();
    
                    $headermaxid = pubhdr::max('id');
    
                    //$slno = $request->slno;
                    $firstname = $request->firstname;
                    $middlename = $request->middlename;
                    $lastname = $request->lastname;
    
                    for($count = 0; $count < count($request->firstname); $count++ )
                    {
                        if($middlename[$count]  != null)
                        {
                            $fullname = $firstname[$count] . ' ' . $middlename[$count] . ' ' . $lastname[$count];
                        }
                        else
                        {
                            $fullname = $firstname[$count] . ' ' . $lastname[$count];
                        }

                        $data = array(
                            'athrfirstname' => $firstname[$count],
                            'athrmiddlename' => $middlename[$count],
                            'athrlastname' => $lastname[$count],
                            'fullname' => $fullname,
                            'pubhdrid' => $headermaxid,
                            'slno' =>  $count + 1
                        );
    
                        $inser_data[] = $data;
                    }
    
                    pubdtl::insert($inser_data);
                }
            }

            DB::commit();
            return "{\"msg\":\"success\"}";
        }
        catch (Exception $ex)
        {
            DB::rollback();
            dd('Exception block', $ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return view('Login.login');

        if(session()->get('hdnselval') == 1) //Ranking
        {
            $rankings = rankings::orderby("id","asc")
            ->select('id','ranking')
            ->get();                                             
            // json_encode($rankings);
            return response()->json($rankings); 
        }
        else if(session()->get('hdnselval') == 2) //BroadArea
        {
            // Fetch Broadareas
            $broadareasData = broadareas::orderby("id","asc")
                                    ->select('id','broadarea')
                                    ->get();

            return response()->json($broadareasData);                        
        }
        else if(session()->get('hdnselval') == 3) //ImpactFactor
        {
            // Fetch ImpactFactor
            $impactfactorsData = impactfactors::orderby("id","asc")
                                    ->select('id','impactfactor')
                                    ->get(); 

            return response()->json($impactfactorsData);                        
        }

        // Session::flush();
        Session::forget('hdnselval');
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

    public function foo(Request $request)
    {
        session()->put('hdnselval', $request->hdnsel);
    }  

    public function showarticle()
    {
        $data = articletypes::orderby("articleid","asc")
                        ->select('articleid','article')
                        ->get();                

        return response()->json($data);                
    }

    function showrankings()
    {
        // Fetch only Rankings -> Others
        $rankingsOnlyAstarData = rankings::select('id','ranking')
        ->where('ranking','=','Core A*')
        ->get();                        
                    
        // Fetch w/o Rankings -> Others
        $rankingsNoOthersData = rankings::orderby("ranking","asc")
                            ->select('id','ranking')
                            ->whereNotIn('ranking', ['Core A*','Others'])
                            ->get();                         

        // Fetch only Rankings -> Others
        $rankingsOnlyOthersData = rankings::select('id','ranking')
        ->where('ranking','=','Others')
        ->get();

        //Fetch all rankings in
        $rankingsData = $rankingsOnlyAstarData->merge($rankingsNoOthersData)->merge($rankingsOnlyOthersData);
        
        return response()->json($rankingsData);
    }

    function showbroadarea()
    {
        //Fetch Broadareas
        $broadareasData = broadareas::orderby("broadarea","asc")
        ->select('id','broadarea')
        ->get();

        return response()->json($broadareasData);
    }

    //Title
    function get_title_data(Request $request)
    {
        Session::forget('title_data');

        session()->put('title_data', trim($request->duptitle));
    }

    function check_dup_title()
    {
        $title = session()->get('title_data');

        $titledata =  pubhdr::where('title',$title)->where('deleted','0')->get(['title']);

        if (count($titledata) > 0){
            $titledata =  pubhdr::where('title',$title)->where('deleted','0')->first()->title;
        }
        else
        {
            $titledata = null;
        }

        echo json_encode($titledata);
    }

    //Conference
    function get_conference_data(Request $request)
    {
        Session::forget('conference_data');

        session()->put('conference_data', trim($request->dupconference));
    }

    function check_dup_conference()
    {
        $conference = session()->get('conference_data');

        $conferencedata =  pubhdr::where('confname',$conference)->where('deleted','0')->get(['confname']);

        if (count($conferencedata) > 0){
            $conferencedata =  pubhdr::where('confname',$conference)->where('deleted','0')->first()->confname;
        }
        else
        {
            $conferencedata = null;
        }

        echo json_encode($conferencedata);
    }
}
