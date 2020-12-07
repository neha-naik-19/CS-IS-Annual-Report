<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use App\Models\categories;
use App\Models\authortypes;
use App\Models\pubhdr;
use App\Models\pubdtl;
use App\Models\rankings;
use App\Models\pubuserdetails;

class SearcheditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch Categories
        $categoryData['data'] = categories::orderby("category","asc")
        ->select('id','category')
        ->get();

        // Fetch AuthorTypes
        $authortypeData['data'] = authortypes::orderby("authortype","asc")
        ->select('id','authortype')
        ->get();

        return view('Publication.searchedit')->with("categoryData",$categoryData)->with('authortypeData', $authortypeData);
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
        DB::beginTransaction();
        
        try{
            // DB::delete('delete from pubdtls where pubhdrid = ?',[$id]);
            // DB::delete('delete from pubhdrs where id = ?',[$id]);

            DB::table('pubhdrs')->where('id', [$id])->update(['deleted' => 1,'updated_at' => Carbon::now()]);

            DB::commit();
        }
        catch (Exception $ex)
        {
            DB::rollback();
            return $ex->getMessage();
        }
    }

    public function getsearchresult(Request $request){
        $rankingoptions = $request->get('ranking');
        $authors = $request->get('author');
        $rankingoption = '';

        $fname = '';
        $mname = '';
        $lname = '';

        if($rankingoptions != null){
            foreach ($rankingoptions as $key => $value) {
                //rankingoptions
                if( $rankingoption == '' ) {
                    $rankingoption = array($value['checked']);
                }
                else
                {
                    array_push($rankingoption, ($value['checked']));
                }
            }

            $rankingoption = implode (',', $rankingoption);
        }
        else{
            $rankingoption = '0';
        }

        if($authors != null){
            foreach ($authors as $key => $value) {
                //fname
                if( $fname == '' ) {
                    $fname = array(($value['fname']==null) ? 'nodata' : $value['fname']);
                }
                else
                {
                    array_push($fname, ($value['fname']==null) ? 'nodata' : $value['fname']);
                }

                //mname
                if( $mname == '' ) {
                    $mname = array(($value['mname']==null) ? 'nodata' : $value['mname']);
                }
                else
                {
                    array_push($mname,($value['mname']==null) ? 'nodata' : $value['mname']);
                }

                //lname
                if( $lname == '' ) {
                    $lname = array(($value['lname']==null) ? 'nodata' : $value['lname']);
                }
                else
                {
                    array_push($lname, ($value['lname']==null) ? 'nodata' : $value['lname']);
                }
            }

            $fname = implode (',', $fname);
            $mname = implode (',', $mname);
            $lname = implode (',', $lname);
        }

        $data =  DB::select('call Get_Search_Data (?,?,?,?,?,?,?,?,?,?,?)', 
                array($request->get('frmdate'),$request->get('todate'),
                $request->get('authortype'),$request->get('category'),
                $request->get('nationality'),$request->get('title'),
                $request->get('conference'),$rankingoption,$fname,$mname,$lname));

        $output = '';
        $nationality = '';
        $string = url('publicationupdate/'.'75'); 

        if(!empty($data))
        {
            foreach($data as $row){
                if($row->nationality == 1){
                    $nationality = 'National';
                }
                elseif($row->nationality == 2){
                    $nationality = 'International';
                }

                $output .= '<tr>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->publicationdate . '</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->authortype .'</td>
                <td style="vertical-align: text-top; width: 15em; font-size: .9em;">' . $row->authorname .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->category .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $nationality .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->article .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->ranking .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->broadarea .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->impactfactor .'</td>
                <td style="vertical-align: text-top; width: 18em; font-size: .9em;">' . $row->title .'</td>
                <td style="vertical-align: text-top; width: 18em; font-size: .9em;">' . $row->confname .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->location .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->volume .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->issue .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->pp .'</td>
                <td style="vertical-align: text-top; width: 10em; font-size: .9em;">' . $row->doi .'</td>
                <td style="vertical-align: text-top; width: 4em; font-size: .9em;"><a target="_blank" href='. url('publicationupdate/'.base64_encode($row->hdrid)) .'>
                <img id="imgsearchedit" src="../image/edit-icon.png"></a></td><td style="vertical-align: text-top; width: 4em; font-size: .9em;"><img id="imgsearchdelete" src="../image/delete-icon.png"></td>
                <td style="display:none; vertical-align: text-top;">' . $row->hdrid . '</td>
                </tr>';
                // base64_decode
            }
        }

        // $data = array(
        //     'search_data' => $output
        // );

        // echo json_encode($data);

        return $output;
    }

    public function showrankings()
    {
        // $data = rankings::orderby("ranking","asc")
        //                 ->select('id','ranking')
        //                 ->get();
                        
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
        $data = $rankingsNoOthersData->merge($rankingsOnlyOthersData);                

        return response()->json($data);                
    }

    public function showauthor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';

            $query = $request->get('query');
            if($query != '')
            {
                // $data = DB::table('pubdtls')
                //     ->select('athrfirstname','athrmiddlename','athrlastname')
                //     ->where('athrfirstname','like','%' .$query. '%')
                //     ->orWhere('athrmiddlename','like','%' .$query. '%')
                //     ->orWhere('athrlastname','like','%' .$query. '%')
                //     ->distinct()
                //     ->get();

                $data = DB::table('pubdtls')
                    ->select('athrfirstname','athrmiddlename','athrlastname')
                    ->join("pubhdrs",function($join){
                        $join->on("pubhdrs.id","=","pubdtls.pubhdrid")
                            ->where('pubhdrs.deleted','=','0');
                    })
                    ->where('athrfirstname','like','%' .$query. '%')
                    ->orWhere('athrmiddlename','like','%' .$query. '%')
                    ->orWhere('athrlastname','like','%' .$query. '%')
                    ->distinct()
                    ->get();
            }
            else
            {
                $data = '';
            }

            if($data != '')
            { 
                $total_row = $data->count();
            }
            else{
                $total_row = 0;
            }

            if($total_row > 0)
            {
                foreach($data as  $row)
                {
                    $output .= '<tr> <td style="text-align: center;"><input type="checkbox" class="chkrnk" id="tblcheck" name="tblcheck[]"/></td>'.
                    '<td id="athrfirstname" name="athrfirstname[]">' . $row->athrfirstname . '</td>'.
                    '<td style="text-align: left;" id="athrmiddlename" name="athrmiddlename[]">' . $row->athrmiddlename . '</td>'.
                    '<td style="text-align: left;" id="athrlastname" name="athrlastname[]">' . $row->athrlastname . '</td> </tr>';           
                }

                $data = array(
                    'table_data' => $output
                );
            }
            else
            {
                $output .= '';
                $data = [];
            }

            echo json_encode($data);
        }
    }
}
