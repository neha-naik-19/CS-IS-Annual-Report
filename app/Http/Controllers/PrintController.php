<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\categories;
use Input;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch Categories
        $categoryprintData['data'] = categories::orderby("category","asc")
            ->select('id','category')
            ->get();
        
        // Fetch AuthorTypes
        $authortypeprintData['data'] = authortypes::orderby("authortype","asc")
            ->select('id','authortype')
            ->get();
        
        return view('Publication.print')->with("categoryData",$categoryprintData)->with('authortypeData', $authortypeprintData);
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

    public function action(Request $request)
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
                    $output .= '<tr> <td style="text-align: center;"><input type="checkbox" class="chk" id="tblcheck" name="tblcheck[]"/></td>'.
                    '<td id="athrfirstname" name="athrfirstname">' . $row->athrfirstname . '</td>'.
                    '<td style="text-align: left;" id="athrmiddlename" name="athrmiddlename">' . $row->athrmiddlename . '</td>'.
                    '<td style="text-align: left;" id="athrlastname" name="athrlastname">' . $row->athrlastname . '</td> </tr>';           
                }

                // $output .= '<tr> <td colspan="4" align="left">  '. $data .' </td></tr>';

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

    function get_print_data($categoryname)
    {
        $data = request()->all();

        $fromdate = session()->get('fromdate');
        $todate = session()->get('todate');
        $authortype = session()->get('authortype');
        $category = session()->get('category');
        $nationality = session()->get('nationality');
        $title = session()->get('title');
        $conference = session()->get('conference');
        $authors = session()->get('author');
        $rankingoptions = session()->get('ranking');

        $print_data = [];
        $type = 0; //no criteria selected
        $subtype = 0; //no sub criteria selected

        $rankingoption = '';
        $fname = '';
        $mname = '';
        $lname = '';

        if($category == "0")
        {
            $category = null;
        }
        else
        {
            $categorydata = categories::select('category')
                        ->where('id',$category)
                        ->first();
        }

        if($authortype == "0"){$authortype = null;}
        if($nationality == "0"){$nationality = null;}

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

        if($fromdate != null && $todate != null && $category == null && $nationality == null && $authors == null) //only date
        {
            $type = 1;
        }

        else if($fromdate != null && $todate != null && $category != null && $nationality == null && $authors == null) // dates, category
        {
            $type = 2;
        }

        else if($fromdate != null && $todate != null && $category == null && $nationality != null && $authors == null) //dates, nationality
        {
            $type = 3;
        }

        else if($fromdate == null && $todate == null && $category != null && $nationality == null && $authors == null) //only category
        {
            $type = 4;
        }

        else if($fromdate == null && $todate == null && $category == null && $nationality != null && $authors == null) //only nationality
        {
            $type = 5;
        }

        else if($fromdate == null && $todate == null && $category != null && $nationality != null && $authors == null) //category, nationality
        {
            $type = 6;
        }

        else if($fromdate != null && $todate != null && $category != null && $nationality != null && $authors == null) //Date, Category, Nationality
        {
            $type = 7;
        }

        else if($fromdate == null && $todate == null && $category == null && $nationality == null && $authors != null) //Only Author
        {
            $type = 8;
            $subtype = 1; //Only Author
        }

        else if($fromdate != null && $todate != null && $category == null && $nationality == null && $authors != null) //Date, Author
        {
            $type = 8;
            $subtype = 2; //Date, Author
        }

        else if($fromdate == null && $todate == null && $category != null && $nationality == null && $authors != null) //Category, Author
        {
            $type = 8;
            $subtype = 3; //Category, Author
        }

        else if($fromdate == null && $todate == null && $category == null && $nationality != null && $authors != null) //Nationality, Author
        {
            $type = 8;
            $subtype = 4; //Nationality, Author
        }

        else if($fromdate != null && $todate != null && $category != null && $nationality == null && $authors != null) //Date,Category, Author
        {
            $type = 8;
            $subtype = 5; //Date,Category, Author
        }

        else if($fromdate != null && $todate != null && $category == null && $nationality != null && $authors != null) //Date,Nationality, Author
        {
            $type = 8;
            $subtype = 6; //Date, Nationality, Author
        }

        else if($fromdate == null && $todate == null && $category != null && $nationality != null && $authors != null) //Category, Nationality, Author
        {
            $type = 8;
            $subtype = 7; //Category, Nationality, Author
        }

        else if($fromdate != null && $todate != null && $category != null && $nationality != null && $authors != null) //full criteria set
        {
            $type = 8;
            $subtype = 8; //full criteria set
        }

        if( $category == null)
        {
            $print_data = DB::select('call Print_Publication_Data (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($fromdate,$todate,$category,$nationality,$fname,$mname,$lname,$type,$subtype,$categoryname,$authortype,$title,$conference,$rankingoption));
        }
        else
        {
            $print_data = DB::select('call Print_Publication_Data (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($fromdate,$todate,$categorydata->category,$nationality,$fname,$mname,$lname,$type,$subtype,$categoryname,$authortype,$title,$conference,$rankingoption));
        }
        
        return $print_data;
    }


    function loadpdf(Request $request)
    {
        $pdf = new dompdf();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->setOptions(['isPhpEnabled' => true,'defaultFont' => 'arial']);

        // $options = new \Dompdf\Options();
        // $options->set('isPhpEnabled', true);
        // $options->set('defaultFont','Helvetica');
        // $dompdf->setOptions($options);

        $pdf->loadHtml($this->convert_print_data_to_html());
        $pdf->setPaper('A4');

        $pdf->output();
        $dom_pdf = $pdf->getDomPDF();

        $canvas = $dom_pdf->get_canvas();

        $canvas->page_text(270, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 7.5, array(0, 0, 0));
        
        return $pdf->stream('Publication.pdf',Array('Attachment'=>0));
    }

    //fromdate ajax post
    public function postfromdate(Request $request)
    {
        Session::forget('fromdate');
        Session::forget('format_fromdate');

        session()->put('fromdate', $request->frmdate);
        session()->put('format_fromdate', $request->format_frmdate);
    }

    //todate ajax post
    public function posttodate(Request $request)
    {
        Session::forget('todate');
        Session::forget('format_todate');

        session()->put('todate', $request->todate);
        session()->put('format_todate', $request->format_todate);
    }

    //authortype ajax post
    public function postauthortype(Request $request)
    {
        Session::forget('authortype');

        session()->put('authortype', $request->authortype);
    }

    //category ajax post
    public function postcategory(Request $request)
    {
        Session::forget('category');

        session()->put('category', $request->category);
    }

    //nationality ajax post
    public function postnationality(Request $request)
    {
        Session::forget('nationality');

        session()->put('nationality', $request->nationality);
    }

    //title ajax post
    public function posttitle(Request $request)
    {
        Session::forget('title');

        session()->put('title', $request->title);
    }

    //conference ajax post
    public function postconference(Request $request)
    {
        Session::forget('conference');

        session()->put('conference', $request->conference);
    }

    //author ajax post
    public function postauthor(Request $request)
    {
        Session::forget('author');

        session()->put('author', $request->author);
    }

    //ranking ajax post
    public function postranking(Request $request)
    {
        Session::forget('ranking');

        session()->put('ranking', $request->ranking);
    }

    public function postform(Request $request)
    {
        Session::forget('fromdate');
        Session::forget('todate');
        Session::forget('format_fromdate');
        Session::forget('format_todate');
        Session::forget('authortype');
        Session::forget('category');
        Session::forget('nationality');
        Session::forget('title');
        Session::forget('conference');
        Session::forget('author');
        Session::forget('ranking');

        // session()->put('fromdate', $request->frmdate);
        // session()->put('todate', $request->todate);
        // session()->put('format_fromdate', $request->format_frmdate);
        // session()->put('format_todate', $request->format_todate);
        // session()->put('authortype', $request->authortype);
        // session()->put('category', $request->category);
        // session()->put('nationality', $request->nationality);
        // session()->put('title', $request->title);
        // session()->put('conference', $request->conference);
        // session()->put('author', $request->author);
        // session()->put('ranking', $request->ranking);
    }

    function convert_print_data_to_html()
    {
        $category = session()->get('category');

        $categorydata = categories::select('category')
                        ->where('id',$category)
                        ->first();    

        if($category == "0"){$category = null;}

        if($category == null){
            $print_journal_data = $this->get_print_data('journal');
            $print_conference_data = $this->get_print_data('conference/workshop');
        }
        else{
            if(strtolower($categorydata->category) == 'journal'){
                $print_journal_data = $this->get_print_data('journal');
                $print_conference_data = [];
            }

            if(strtolower($categorydata->category) == 'conference/workshop'){
                $print_journal_data = [];
                $print_conference_data = $this->get_print_data('conference/workshop');
            }
        }

        $maxdate = '';
        $mindate = '';

        if(session()->get('format_fromdate') != null && session()->get('format_todate') != null)
        {
            $mindate = session()->get('format_fromdate');
            $maxdate = session()->get('format_todate');
        }
        else
        {
            $date = DB::table('pubhdrs')
                        ->select(DB::Raw('DATE_FORMAT(MIN(pubdate), "%Y-%m-%d") as fromdate'), DB::Raw('DATE_FORMAT(MAX(pubdate), "%Y-%m-%d") as todate'))
                        ->first();

            $mindate = $date->fromdate;
            $maxdate = $date->todate;

            $min_day = Carbon::parse($mindate)->startOfMonth()->day;
            $min_month = Carbon::parse($mindate)->month;
            $min_year = Carbon::parse($mindate)->year;

            $max_day = Carbon::parse($maxdate)->lastOfMonth()->day;
            $max_month = Carbon::parse($maxdate)->month;
            $max_year = Carbon::parse($maxdate)->year;

            $mindate = $min_day."/".$min_month."/".$min_year;
            $maxdate = $max_day."/".$max_month."/".$max_year;
        }
        $output = '';   
        $output = '<body>';

        $output .= '<style>
                    .pagenum:before {
                        content: counter(page);
                    }
                    </style>';

        $output .= '<div align="center" style="font-size: 14px; font-weight: bold; font-family: Calibri, Arial, sans-serif; margin-top:10px;">DEPARTMENT OF COMPUTER SCIENCE & INFORMATION SYSTEMS</div><br>';            

        if($print_journal_data != []){

            $output .= '<div align="left" style="font-size: 12px; font-family: Calibri, Arial, sans-serif; margin-top:10px;">LIST OF RESEARCH PUBLICATIONS IN SCOPUS INDEXED JOURNALS : 
                '.$mindate. ' - '.$maxdate.'</div>
                <div align="left" style="font-size: 12px; margin-top:10px;">Papers Published by Faculty in Journals</div>
                <hr style="border-width: .2px; margin-bottom:20px;">
            ';

            $num = 0;
            foreach($print_journal_data as $print)
            {
                $num = $num + 1;

                $output .=
                '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 11px; font-family: Calibri, Arial, sans-serif;">
                    <tr>
                        <td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial,sans-serif;">'.$num.'.</td>
                        <td align="justify" style="border: 0px solid; padding-bottom:12px; font-family: Calibri, Arial,
                        sans-serif;">'.trim($print->authorname).'. '.trim($print->title);

                if($print->conference != ''){
                    $output .= ', '.trim($print->conference);
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim($print->Doi);
                }

                if($print->volume != ''){
                    $output .= ', '.trim($print->volume);
                }

                if($print->issue != ''){
                    $output .= ', '.trim($print->issue);
                }

                if($print->pages != ''){
                    $output .= ', '.trim($print->pages);
                }

                $output .= ', '.Carbon::parse($print->pubdate)->year;

                if($print->article != ''){
                    $output .= ' ('.$print->article.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.' , ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->broadarea.')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' (ImpactFactor='.$print->impactfactor.')';
                }

                $output .= '</td></tr></table>';
            }
        }

        if($print_conference_data != []){

            $output .= '<br><br><div align="left" style="font-size: 12px; font-family: Calibri, Arial, sans-serif; margin-top:10px;">CONFERENCES/WORKSHOPS/SEMINAR ATTENDED/PAPERS PRESENTED : '.$mindate. ' - '.$maxdate.' </div>
                        <hr style="border-width: .2px; margin-bottom:20px;">
                    ';

            $num = 0;
            $nationality ='';
            $prenationality='';
            $checkrepeater = false;
            $type = '';  
            foreach($print_conference_data as $print)
            {
                if($print->nationality == 1){
                    $nationality ='i)  National';
                    $type = 'national';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 0;
                        $checkrepeater = false;
                    }
                    
                    $prenationality = $type;
                    
                }
                
                if($print->nationality == 2){
                    if($type <> 'national'){
                        $nationality ='i)  International';
                    }
                    elseif($type == 'national'){
                        $nationality ='ii)  International';
                    }
                    $type = 'international';

                    if($prenationality == $type){
                        $checkrepeater = true;
                    }
                    else{
                        $num = 0;
                        $checkrepeater = false;
                    }

                    $prenationality = $type;
                    
                }

                $num = $num + 1;

                if($checkrepeater == false){
                    $output .=
                    '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 12px; font-family: Calibri, Arial, sans-serif;">
                        <tr><br><td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial, sans-serif;"> '. $nationality .':</td></tr>
                    </table>';
                }

                $output .=
                '<table width="100%" style="border-collapse: collapse; border: 0px; font-size: 11px; font-family: Calibri, Arial, sans-serif;">
                    <tr>
                        <td valign="top" style="border: 0px solid; width: 20px; font-family: Calibri, Arial, sans-serif;">'.$num.'.</td>
                        <td align="justify" style="border: 0px solid; padding-bottom:12px; font-family: Calibri, Arial,
                        sans-serif;">'.trim($print->authorname).'. '.trim($print->title);

                if($print->conference != ''){
                    $output .= ', '.trim($print->conference);
                }

                if($print->Doi != ''){
                    $output .= ', DOI: '.trim($print->Doi);
                }

                if($print->volume != ''){
                    $output .= ', '.trim($print->volume);
                }

                if($print->issue != ''){
                    $output .= ', '.trim($print->issue);
                }

                if($print->pages != ''){
                    $output .= ', '.trim($print->pages);
                }

                $output .= ', '.Carbon::parse($print->pubdate)->year;

                $output .= ', '.trim($print->location);

                if($print->article != ''){
                    $output .= ' ('.$print->article.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->broadarea.', ImpactFactor='.$print->impactfactor.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.', '.$print->broadarea.')';
                }

                if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->ranking.')';
                }

                if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                    $output .= ' ('.$print->broadarea.')';
                }

                if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                    $output .= ' ( ImpactFactor='.$print->impactfactor.')';
                }
                
                $output .= '</td></tr></table>';
            }  
        }
        
        // $output .= '<div style="font-size: 9px; font-family: Calibri, Arial, sans-serif; position: fixed; bottom: -60px; left: 0px;
        // right: 0px; height: 50px; text-align: center; ">
        // Page <span class="pagenum"></span>
        // </div >';

        $output .= '</body>';

        // Session::forget('fromdate');
        // Session::forget('todate');
        // Session::forget('format_fromdate');
        // Session::forget('format_todate');
        // Session::forget('authortype');
        // Session::forget('category');
        // Session::forget('nationality');
        // Session::forget('title');
        // Session::forget('conference');
        // Session::forget('author');
        // Session::forget('ranking');

        return $output;
    }


    //Convert to Word
    function createworddocx(){
        $word = new \PhpOffice\PhpWord\PhpWord();
        $textAlign = new \PhpOffice\PhpWord\SimpleType\TextAlignment();

        $word->getSettings()->setMirrorMargins(true);

        $word->getSettings()->setHideGrammaticalErrors(true);
        $word->getSettings()->setHideSpellingErrors(true);
        // $word->addParagraphStyle('p2Style', ['align'=> $textAlign ::CENTER]);

        $newsection = $word->addSection();

        $sectionStyle = $newsection->getStyle();

        //half inch top margin
        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));

        //half inch bottom margin
        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));
        
        //half inch left margin
        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5));
        
        // half inch right margin
        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5)); //cmToTwip -> cm, inchToTwip -> inch

        $category = session()->get('category');

        $categorydata = categories::select('category')
                        ->where('id',$category)
                        ->first();

        $newline = "\n";

        if($category == "0"){$category = null;}

        if($category == null){
            $print_journal_data = $this->get_print_data('journal');
            $print_conference_data = $this->get_print_data('conference/workshop');
        }
        else{
            if(strtolower($categorydata->category) == 'journal'){
                $print_journal_data = $this->get_print_data('journal');
                $print_conference_data = [];
            }

            if(strtolower($categorydata->category) == 'conference/workshop'){
                $print_journal_data = [];
                $print_conference_data = $this->get_print_data('conference/workshop');
            }
        }
 
        $maxdate = '';
        $mindate = '';
    
        if(session()->get('format_fromdate') != null && session()->get('format_todate') != null)
        {
            $mindate = session()->get('format_fromdate');
            $maxdate = session()->get('format_todate');
        }
        else
        {
            $date = DB::table('pubhdrs')
                ->select(DB::Raw('DATE_FORMAT(MIN(pubdate), "%Y-%m-%d") as fromdate'), DB::Raw('DATE_FORMAT(MAX(pubdate), "%Y-%m-%d") as todate'))
                ->first();
        
            $mindate = $date->fromdate;
            $maxdate = $date->todate;
        
            $min_day = Carbon::parse($mindate)->startOfMonth()->day;
            $min_month = Carbon::parse($mindate)->month;
            $min_year = Carbon::parse($mindate)->year;
        
            $max_day = Carbon::parse($maxdate)->lastOfMonth()->day;
            $max_month = Carbon::parse($maxdate)->month;
            $max_year = Carbon::parse($maxdate)->year;
        
            $mindate = $min_day."/".$min_month."/".$min_year;
            $maxdate = $max_day."/".$max_month."/".$max_year;
        }
    
        $heading1 = htmlspecialchars('DEPARTMENT OF COMPUTER SCIENCE & INFORMATION SYSTEMS');
    
        $newsection->addText($heading1, array('bold'=>true, 'name'=> 'Arial', 'size'=>13,'spaceBefore' => 8, 'spaceAfter' => 10,
            'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER), 
            ['align'=> $textAlign ::CENTER]);
    
            //Start ==> Only Journal data display
            if($print_journal_data != []){
                $journalheading = 'LIST OF RESEARCH PUBLICATIONS IN SCOPUS INDEXED JOURNALS : ' .$mindate. ' - '.$maxdate;
    
                $newsection->addText($newline);                                 
                $newsection->addText($journalheading, array('name'=> 'Arial','size'=>10));
        
                //$newsection->addText($newline);
                $newsection->addText('Papers Published by Faculty in Journals', array('name'=> 'Arial','size'=>9,'align' => 'end'));
                
                $newsection->addText('', [], ['borderBottomSize'=>1, 'borderBottomColor'=>'A9A9A9']);
    
                //$newsection->addText($newline);
    
                $fontStyle = array('size'=>8, 'name'=>'Arial' /*,'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 */);
                $noSpace = array('spaceAfter' => -1);
                $bold = array('bold'=> true);
                $aligncelltext = array('align'=> $textAlign ::BOTH);
                $table = $newsection->addTable();
                
                $num = 1;
                foreach($print_journal_data as $print){
    
                    $output = trim(htmlspecialchars($print->authorname)).'. '.trim(htmlspecialchars($print->title)); //Author name , Title
    
                    if($print->conference != ''){
                        $output .= ', '.trim(htmlspecialchars($print->conference)); //Conference
                    }
    
                    if($print->Doi != ''){
                        $output .= ', DOI: '.trim(htmlspecialchars($print->Doi)); //DOI
                    }
    
                    if($print->volume != ''){
                        $output .= ', '.trim(htmlspecialchars($print->volume)); //Volume
                    }
    
                    if($print->issue != ''){
                        $output .= ', '.trim(htmlspecialchars($print->issue)); //Issue
                    }
    
                    if($print->pages != ''){
                        $output .= ', '.trim(htmlspecialchars($print->pages)); //Pages
                    }
    
                    $output .= ', '.Carbon::parse($print->pubdate)->year; //Year
     
                    if($print->article != ''){
                        $output .= ' ('.htmlspecialchars($print->article).')'; //Article
                    }
    
                    //Start => Ranking, BroadArea, ImpactFactor
                    if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).' , ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->broadarea).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                        $output .= ' (ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
                    //End => Ranking, BroadArea, ImpactFactor
    
                    $table->addRow();
                    $table->addCell(550)->addText( $num ++ .'.',$fontStyle);
                    $table->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
                }
            }
            //End ==> Only Journal data display
    
            //Start ==> Only Conference data display
            if($print_conference_data != []){
    
                $newsection->addText($newline);
    
                $conferenceheading = 'CONFERENCES/WORKSHOPS/SEMINAR ATTENDED/PAPERS PRESENTED : ' .$mindate. ' - '.$maxdate;
    
                //$newsection->addText($newline);
                $newsection->addText($conferenceheading, array('name'=> 'Arial','size'=>9,'align' => 'end'));
                
                $newsection->addText('', [], ['borderBottomSize'=>1, 'borderBottomColor'=>'A9A9A9']);
    
                //$newsection->addText($newline);
    
                $fontStyle = array('size'=>8, 'name'=>'Arial');
                $nationalityfontStyle = array('bold'=>true,'size'=>11, 'name'=>'Arial');
                $noSpace = array('spaceAfter' => 0);
                $aligncelltext = array('align'=> $textAlign ::BOTH);
    
                $table = $newsection->addTable();
                $table1 = $newsection->addTable();
                $table2 = $newsection->addTable();
                $table3 = $newsection->addTable();
    
                $num = 1;
                $nationality ='';
                $prenationality='';
                $checkrepeater = false;
                $type = ''; 
                $output = '';
                foreach($print_conference_data as $print){
    
                    if($print->nationality == 1){
                        $nationality ='i)  National';
                        $type = 'national';
    
                        if($prenationality == $type){
                            $checkrepeater = true;
                        }
                        else{
                            $num = 1;
                            $checkrepeater = false;
                        }
                        
                        $prenationality = $type;
                    }
                    
                    if($print->nationality == 2){
                        if($type <> 'national'){
                            $nationality ='i)  International';
                        }
                        elseif($type == 'national'){
                            $nationality ='ii)  International';
                        }
                        $type = 'international';
    
                        if($prenationality == $type){
                            $checkrepeater = true;
                        }
                        else{
                            $num = 1;
                            $checkrepeater = false;
                        }
    
                        $prenationality = $type;
                    }
    
                    if($checkrepeater == false){
                        if($type == 'national'){
                            $table->addRow();
                            $table->addCell(10000)->addText($nationality,array('bold'=>true),$aligncelltext,$nationalityfontStyle);
                        }
    
                        if($type == 'international'){
                            $table2->addRow();
                            $table2->addCell(10000)->addText($nationality,array('bold'=>true),$aligncelltext,$nationalityfontStyle);
                        }
                    }
    
                    $output = trim(htmlspecialchars($print->authorname)).'. '.trim(htmlspecialchars($print->title)); //Author name , Title
    
                    if($print->conference != ''){
                        $output .= ', '.trim(htmlspecialchars($print->conference)); //Conference
                    }
    
                    if($print->Doi != ''){
                        $output .= ', DOI: '.trim(htmlspecialchars($print->Doi)); //DOI
                    }
    
                    if($print->volume != ''){
                        $output .= ', '.trim(htmlspecialchars($print->volume)); //Volume
                    }
    
                    if($print->issue != ''){
                        $output .= ', '.trim(htmlspecialchars($print->issue)); //Issue
                    }
    
                    if($print->pages != ''){
                        $output .= ', '.trim(htmlspecialchars($print->pages)); //Pages
                    }
    
                    $output .= ', '.Carbon::parse($print->pubdate)->year; //Years
    
                    $output .= ', '.trim(htmlspecialchars($print->location)); //Location
    
                    if($print->article != ''){
                        $output .= ' ('.htmlspecialchars($print->article).')'; //Article
                    }
    
                    //Start => Ranking, BroadArea, ImpactFactor
                    if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->broadarea).', ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor != ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea != '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).', '.htmlspecialchars($print->broadarea).')';
                    }
    
                    if($print->ranking != '' && $print->broadarea == '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->ranking).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea != '' && $print->impactfactor == ''){
                        $output .= ' ('.htmlspecialchars($print->broadarea).')';
                    }
    
                    if($print->ranking == '' && $print->broadarea == '' && $print->impactfactor != ''){
                        $output .= ' ( ImpactFactor='.htmlspecialchars($print->impactfactor).')';
                    }
                    //End => Ranking, BroadArea, ImpactFactor
                    
                    if($type == 'national'){
                        $table1->addRow();
                        $table1->addCell(200)->addText( '',$fontStyle);
                        $table1->addCell(550)->addText( $num ++ .'.',$fontStyle);
                        $table1->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
                    }
    
                    if($type == 'international'){
                        $table3->addRow();
                        $table3->addCell(200)->addText( '',$fontStyle);
                        $table3->addCell(550)->addText( $num ++ .'.',$fontStyle);
                        $table3->addCell(10000)->addText($output,$noSpace,$aligncelltext,$fontStyle); //$noSpace should be before $aligncelltext
                    }
                }
            }
            //End ==> Only Conference data display
    
            $footer = $newsection->addFooter();
            $footer->addPreserveText('Page {PAGE} of {NUMPAGES}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,'size'=>1));
            $newsection->addPageBreak();
    
            $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, "Word2007");
            try{
                $objectWriter->save(storage_path('PublicationWordExport.docx'));
            }
            catch(Exception $e){
    
            }
    
        return response()->download(storage_path('PublicationWordExport.docx'));
    }



}
