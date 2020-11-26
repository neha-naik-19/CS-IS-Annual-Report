<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions;
use Illuminate\Support\Facades\Session;
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

class UpdatedataController extends Controller
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

        // Fetch Categories
        $categoryData['data'] = categories::orderby("category","asc")
                                ->select('id','category')
                                ->get();

        // Fetch AuthorTypes
        $authortypeData['data'] = authortypes::orderby("authortype","asc")
                                ->select('id','authortype')
                                ->get();

        // Fetch ArticleType based on AuthorType
        if(!empty($data)){
            foreach($data as $row){
                $articletypeData['data'] = articletypes::orderby("journalconfernce","asc")
                                ->select('articleid','article')
                                ->get();
            }
        }                        
                                
        // Fetch w/o Rankings -> Others
        $rankingsNoOthersData = rankings::orderby("ranking","asc")
                                ->select('id','ranking')
                                ->where('ranking','<>','Others')
                                ->get();                         

        // Fetch only Rankings -> Others
        $rankingsOnlyOthersData = rankings::select('id','ranking')
                                ->where('ranking','=','Others')
                                ->get();

        //Fetch all rankings in                        
        $rankingsData['data'] = $rankingsNoOthersData->merge($rankingsOnlyOthersData);
                                
        // Fetch Broadareas
        $broadareasData['data'] = broadareas::orderby("broadarea","asc")
                                ->select('id','broadarea')
                                ->get();                      

        return view('Publication.edit')->with("categoryData",$categoryData)->with('authortypeData', $authortypeData)->with('articletypeData',$articletypeData)
        ->with('rankingsData', $rankingsData)->with('broadareasData', $broadareasData)
        ->with('headerid',$headerid)->with('data',$data)->with('authordata',$authordata);
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
        try{
            if($request->ajax()){

                $pubhdr = new pubhdr();
                
                $data = pubhdr::whereId($request->hdnheaderid)->first();

                DB::beginTransaction();

                //Ranking
                if($request->updateranking == 0){
                    $ranking = null;
                }
                elseif($request->updateranking == null){
                    $ranking = null;
                }
                else{
                    $ranking = $request->updateranking;
                }

                //BroadArea
                if($request->updateselbroadarea == 0){
                    $broadarea = null;
                }
                elseif($request->updateselbroadarea == null){
                    $broadarea = null;
                }
                else{
                    $broadarea = $request->updateselbroadarea;
                }

                //Article
                if($request->updatearticle == 0){
                    $article = null;
                }
                elseif($request->updatearticle == null){
                    $article = null;
                }
                else{
                    $article = $request->updatearticle;
                }

                //Nationality
                if($request->updatenationality == 0){
                    $nationality = null;
                }
                elseif($request->updatenationality == null){
                    $nationality = null;
                }
                else{
                    $nationality = $request->updatenationality;
                }

                //ImpactFactor
                if($request->updateimpactfactor == 0){
                    $impactfactor = null;
                }
                elseif($request->updateimpactfactor == null){
                    $impactfactor = null;
                }
                else{
                    $impactfactor = $request->updateimpactfactor;
                }

                $data->update([ //updateing to pubhdr table
                    'categoryid'     => $request->updatecategory,
                    'authortypeid'   => $request->updateauthortype,
                    'articletypeid'  => $article,
                    'nationality'    => $nationality,
                    'pubdate'        => $request->updatedatefld,
                    'title'          => ($request->updatetitle != null) ? $request->updatetitle : null,
                    'confname'       => ($request->updateconference != null) ? $request->updateconference : null,
                    'place'          => $request->updateplace,
                    'rankingid'      => $ranking,
                    'broadareaid'    => $broadarea,
                    'impactfactor'   => $impactfactor,
                    'volume'         => ($request->updatevolume != null) ? $request->updatevolume : null,
                    'issue'          => ($request->updateissue != null) ? $request->updateissue : null,
                    'pp'             => ($request->updatepp != null) ? $request->updatepp : null,
                    'digitallibrary' => ($request->updatedigitallibrary != null) ? $request->updatedigitallibrary : null,
                    'userid'         => 11,
                    'updated_at'     => Carbon::now()
                ]);

                $pubuserdetails = new pubuserdetails(); 
                $pubuserdetails->pubid = $request->hdnheaderid;
                $pubuserdetails->userid = 11;
                $pubuserdetails->type = 'update';
                $pubuserdetails->updated_date = Carbon::now()->toDateString();
                $pubuserdetails->updated_time = Carbon::now()->toTimeString();
                $pubuserdetails->save();

                DB::delete('DELETE FROM pubdtls WHERE pubhdrid = ?', [$request->hdnheaderid]);

                $firstname = $request->updatefirstname;
                $middlename = $request->updatemiddlename;
                $lastname = $request->updatelastname;
                $hdrid = $request->hdnheaderid;

                for($count = 0; $count < count($request->updatefirstname); $count++ )
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
                        'pubhdrid' => $hdrid,
                        'slno' =>  $count + 1
                    );

                    $inser_data[] = $data;
                }
                pubdtl::insert($inser_data);

                DB::commit();
            }

        }
        catch (Exception $ex)
        {
            DB::rollback();
            return $ex->getMessage();
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

    public function getcategory(Request $request)
    {
        session()->put('categorytext', $request->category);
    }
    
    public function showarticle()
    {
        $categorytext = session()->get('categorytext');
        Session::forget('categorytext');

        $data = articletypes::orderby("articleid","asc")
                        ->select('articleid','article')
                        ->Where('journalconfernce','=',$categorytext)
                        ->get();                

        return response()->json($data);                
    }
}
