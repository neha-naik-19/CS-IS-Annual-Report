<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;
use RenanBr\BibTexParser\Processor;

use App\Models\categories;
use App\Models\authortypes;
use App\Models\rankings;
use App\Models\broadareas;
use App\Models\pubhdr;
use App\Models\pubdtl;
use App\Models\articletypes;
use App\Models\User;

use Symfony\Component\Debug\Exception;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class BibtexController extends Controller
{
    private $firstname = '';
    private $middlename = '';
    private $lastname = '';

    private $isdulpicate = 0;
    private $dupId = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Fetch AuthorTypes
        $authortypeprintData['data'] = authortypes::orderby("authortype","asc")
            ->select('id','authortype')
            ->get();

        return view('Publication.bibtex')->with('authortypeData', $authortypeprintData);
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
        $content = base64_decode($request->filedata);

        $dupHeaderId = session()->get('headerId');
        Session::forget('headerId');

        $month = 0;
        $year = 0;
        $date = '';
        $conference = null;
        $place = null;
        $title = '-';
        $volume = null;
        $issue = null;
        $pages = null;
        $doi = null;
        $publisher = null;
        $msg = [];

        $isError = 0;

        DB::beginTransaction();
        
        try {
            // Create and configure a Listener
            $listener = new Listener();
            $listener->addProcessor(new Processor\TagNameCaseProcessor(CASE_LOWER));

            // Create a Parser and attach the listener
            $parser = new Parser();
            $parser->addListener($listener);

            $isError = 1;
            $parser->parseString($content); // or parseFile('/path/to/file.bib')
            $entries = $listener->export();

            $isError = 2;

            foreach ($entries as $key => $value) {
                $arraykeys = array_keys($value);

                $month = null;
                $year = null;
                $date = null;
                $conference = null;
                $place = null;
                $title = null;
                $volume = null;
                $issue = null;
                $pages = null;
                $doi = null;
                $publisher = null;
                $categoryid = 0;

                $userid = User::where('email',Auth::user()->email)->first()->id;

                $pubhdr = new pubhdr();
                $pubhdr->authortypeid = $request->authortype;

                if(strtolower($value['type']) == "article" || strtolower($value['type']) == "misc" || strtolower($value['type']) == "journal")
                {
                    // Fetch Category id for journal
                    $categoryid = categories::where('category', 'journal')->first()->id;
                }
                if(strtolower($value['type']) == "conference" || strtolower($value['type']) == "inproceedings")
                {
                    // Fetch Category id for conference
                    $categoryid = categories::where('category', 'Conference/Workshop')->first()->id;
                }

                //check if key from a foreach loop is in an array
                /***********Date*************/
                if(in_array('month',$arraykeys)){
                    $month = $value['month'];
                }

                if(in_array('year',$arraykeys)){
                    $year = $value['year'];
                }

                if($month != 0)
                {
                    if(strlen($month) > 2)
                    {
                        if (!preg_match("/^[0-9]+$/", $month))
                        {
                            $month = 0;
                        }
                    }
                }

                //publication date
                if($month != 0 && $year != 0)
                {
                    $date = $value['year'] . "-" . $month . "-01";
                }
                if($month == 0 && $year != 0)
                {
                    $date = $value['year'] . "-01-01";
                }
                if($month != 0 && $year == 0)
                {
                    $date = Carbon::now()->year . "-" . $month . "-01";
                }
                if($month == 0 && $year == 0)
                {
                    $date = Carbon::now();
                }
                /***********Date*************/

                /***********Conference*************/
                if(in_array('journal',$arraykeys)){
                    $conference = $value['journal'];
                }

                if(in_array('booktitle',$arraykeys)){
                    $conference = $value['booktitle'];
                }

                if(in_array('conference',$arraykeys)){
                    $conference = $value['conference'];
                }
                /***********Conference*************/

                /***********Place*************/
                if(in_array('address',$arraykeys)){ 
                    $place = $value['address'];
                }

                if(in_array('place',$arraykeys)){
                    $place = $value['place'];
                }
                /***********Place*************/

                /***********Title*************/
                if(in_array('booktitle',$arraykeys)){
                    $title = $value['booktitle'];
                }

                if(in_array('title',$arraykeys)){
                    $title = $value['title'];
                }
                /***********Title*************/

                /***********Volume*************/
                if(in_array('volume',$arraykeys)){
                    $volume = $value['volume'];
                }
                /***********Volume*************/

                /***********Issue*************/
                if(in_array('issue',$arraykeys)){
                    $issue = $value['issue'];
                }
                /***********Issue*************/

                /***********Pages*************/
                if(in_array('pages',$arraykeys)){
                    $pages = $value['pages'];
                }
                /***********Pages*************/

                /***********DOI*************/
                if(in_array('doi',$arraykeys)){
                    $doi = $value['doi'];
                }
                /***********DOI*************/

                /***********publisher*************/
                if(in_array('publisher',$arraykeys)){
                    $publisher = $value['publisher'];
                }
                /***********publisher*************/

                /***********Author*************/
                $authors = [];
                $pub_data = [];
                $test = [];

                $authFname = [];
                $authMname = [];
                $authLname = [];

                if(in_array('author',$arraykeys)){
                    $authorsArray = str_replace('/\s\s+/', ' ', $value['author']);

                    $authorsArray = str_replace(' and ', '~', $authorsArray);
                    $authorsArray = str_replace('and ', '~', $authorsArray);
                    $authorsArray = str_replace(' and', '~', $authorsArray);

                    if(str_contains($authorsArray,"~"))
                    {
                        $authorsCopy = array_map('trim', (explode("~" , $authorsArray)));

                        for($i=0; $i < count($authorsCopy); $i++){
                            if(str_contains($authorsCopy[$i], ",")){
                                $wordCount = str_word_count($authorsCopy[$i]);

                                if($wordCount <= 4)
                                {
                                    if (preg_match('/\s/',$authorsCopy[$i])) {
                                        $commaSeperatedArray = str_replace(' , ', '&', $authorsCopy[$i]);
                                        $commaSeperatedArray = str_replace(', ', '&', $commaSeperatedArray);
                                        $commaSeperatedArray = str_replace(' ,', '&', $commaSeperatedArray);
                                        
                                        $commaSeperatedArray = array_map('trim', (explode("&" , $commaSeperatedArray)));

                                        for($k=0; $k < count($commaSeperatedArray); $k++){
                                            if (preg_match('/\s/',$commaSeperatedArray[$k])) {
                                                if( count($authors) === 0 ) {
                                                    $authors = array($commaSeperatedArray[$k]);
                                                }else{
                                                    array_push($authors, $commaSeperatedArray[$k]);
                                                }
                                            }
                                            else{
                                                if( count($authors) === 0 ) {
                                                    $authors = array($authorsCopy[$i]);
                                                    break;
                                                }else{
                                                    array_push($authors, $authorsCopy[$i]);
                                                    break;
                                                }
                                            }
                                        }
                                    
                                    }
                                    else{
                                        if( count($authors) === 0 ) {
                                            $authors = array($authorsCopy[$i]);
                                        }else{
                                            array_push($authors, $authorsCopy[$i]);
                                        }
                                    }
                                }
                                else{
                                    $commaCount = substr_count($authorsCopy[$i], ',');

                                    $commaSeperatedArray = str_replace(' , ', '@', $authorsCopy[$i]);
                                    $commaSeperatedArray = str_replace(', ', '@', $commaSeperatedArray);
                                    $commaSeperatedArray = str_replace(' ,', '@', $commaSeperatedArray);

                                    $commaSeperatedArray = array_map('trim', (explode("@" , $commaSeperatedArray)));

                                    for($j=0; $j < count($commaSeperatedArray); $j++){
                                        $wordCount = str_word_count($commaSeperatedArray[$j]);

                                        if($wordCount <= 4){
                                            if( count($authors) === 0 ) {
                                                $authors = array($commaSeperatedArray[$j]);
                                            }else{
                                                array_push($authors, $commaSeperatedArray[$j]);
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                if( count($authors) === 0 ) {
                                    $authors = array($authorsCopy[$i]);
                                }else{
                                    array_push($authors, $authorsCopy[$i]);
                                }
                            }
                        } 
                    }
                    else
                    {
                        $sinlgeAuthorArrays =  str_replace(' , ', '~', $authorsArray);
                        $sinlgeAuthorArrays =  str_replace(', ', '~', $sinlgeAuthorArrays);
                        $sinlgeAuthorArrays =  str_replace(' ,', '~', $sinlgeAuthorArrays);

                        if(str_contains($sinlgeAuthorArrays,"~")){
                            $checkSingleContent = array_map('trim', (explode("~" , $sinlgeAuthorArrays)));
                            
                            foreach ($checkSingleContent as $arrayContent) {
                                $contentCheck = array_map('trim', (explode(" " , $arrayContent)));

                                if(count($contentCheck) > 1){
                                    $authors = array_map('trim', (explode("~" , $sinlgeAuthorArrays)));
                                    break;
                                }
                                else{
                                    $authors = array($authorsArray);
                                    break;
                                }
                            }
                        
                        }else
                        {
                            $authors = array($authorsArray);
                        }
                    }
                }
                /***********Author*************/

                $pubhdr->categoryid = $categoryid;
                $pubhdr->pubdate = $date;

                $pubhdr->nationality = null;
                $pubhdr->broadareaid = null;
                $pubhdr->impactfactor = null;
                $pubhdr->rankingid = null;
                $pubhdr->articletypeid = null;

                $pubhdr->title = $title;
                $pubhdr->confname = $conference;
                $pubhdr->description = null;
                $pubhdr->place = $place;

                $pubhdr->volume = $volume;
                $pubhdr->issue = $issue;
                $pubhdr->pp = $pages;
                $pubhdr->digitallibrary = $doi;
                $pubhdr->publisher = $publisher;
                $pubhdr->userid = $userid;
                $pubhdr->deleted  = 0;
                $pubhdr->description = $request->note;
                $pubhdr->bibtexfile = $request->bibtexfile;
                $pubhdr->created_at = Carbon::now();

                //save data in pubhdrs table
                $pubhdr->save();

                $headermaxid = pubhdr::max('id');

                $pubdtls_slno = 1;
                foreach ($authors as $author) {
                    $pub_data[] = $this->author_display($headermaxid,$author,$pubdtls_slno++, 1);
                }

                pubdtl::insert($pub_data);
                // DB::commit();
            }

            if($dupHeaderId !== null){
                foreach ($dupHeaderId as $singleDupId) 
                {
                    DB::table('pubhdrs')->where('id', $singleDupId)->update(['deleted' => 1]);
                }
            }

            DB::commit();

            // return "{\"msg\":\"success\"}";

            $msg = array(
                'msg' => 'success',
                'num' => 0,
            );

            return response()->json($msg);

        } catch (\Exception $e) {
            // dd ('hello');
            DB::rollback();

            // return  json_encode("error");

            $msg = array(
                'msg' => 'error',
                'num' => $isError,
            );

            return response()->json($msg);
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

    function author_display($headermaxid,$author,$pubdtls_slno,$validate)
    {
        try {
            $this->firstname = '';
            $this->lastname = '';
            $this->middlename = '';
    
            // foreach ($authors as $author) {
                $singleauthordata = (explode(" " , $author));
    
                $datacount = count($singleauthordata);
                
                if(str_contains($author,",")) //Author name includes ',' and 'and'
                {
                    if(is_array($singleauthordata) && count($singleauthordata) > 0){
    
                        if($datacount > 2) //fname,mname,lname
                        {
                            for($i=0; $i < $datacount ; $i++) {
                                if($i == 0 && str_contains($singleauthordata[$i],","))
                                {
                                    $singlelastdata = rtrim($singleauthordata[$i], ", ");
    
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array($singlelastdata);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, $singlelastdata);
                                    }
                                }
    
                                if($i == 1)
                                {
                                    $singlefirstdata = rtrim($singleauthordata[$i], ", ");
    
                                    if($this->firstname == '')
                                    {   
                                        $this->firstname = array($singlefirstdata);
                                    }
                                    else
                                    {
                                        array_push($this->firstname, $singlefirstdata);
                                    }
                                }
    
                                if($i == 2)
                                {
                                    $singlemiddledata = rtrim($singleauthordata[$i], ", ");
    
                                    if($this->middlename == '')
                                    {   
                                        $this->middlename = array($singlemiddledata);
                                    }
                                    else
                                    {
                                        array_push($this->middlename, $singlemiddledata);
                                    }
                                }
    
                                if($i > 2)
                                {
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, $singleauthordata[$i]);
                                    }
                                }
                            }
                        }
                        else //fname,lname
                        {
                            for($i=0; $i < $datacount ; $i++) {
                                if($i == 0)
                                {
                                    $singlelastdata = rtrim($singleauthordata[$i], ", ");
    
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array($singlelastdata);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, $singlelastdata);
                                    }
                                }
    
                                if($i == 1)
                                {
                                    $singlefirstdata = rtrim($singleauthordata[$i], ", ");
    
                                    if($this->firstname == '')
                                    {   
                                        $this->firstname = array($singlefirstdata);
                                    }
                                    else
                                    {
                                        array_push($this->firstname, $singlefirstdata);
                                    }
    
                                    if($this->middlename == '')
                                    {   
                                        $this->middlename = array(null);
                                    }
                                    else
                                    {
                                        array_push($this->middlename, null);
                                    }
                                }
                            }
                        }
                    }
                }
                else //Author name includes only ',' or 'and'
                {
                    if(is_array($singleauthordata) && count($singleauthordata) > 0){
          
                        for($i=0; $i < $datacount ; $i++) {
                            if($datacount > 2) //fname,mname,lname
                            {
                                if($i == 0)
                                {
                                    if($this->firstname == '')
                                    {   
                                        $this->firstname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->firstname, $singleauthordata[$i]);
                                    }
                                }
                                if($i == 1)
                                {
                                    if($this->middlename == '')
                                    {   
                                        $this->middlename = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->middlename, $singleauthordata[$i]);
                                    }
                                }
                                if($i == 2  || $i > 2)
                                {
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, $singleauthordata[$i]);
                                    }
                                }
                            }
                            elseif($datacount == 2) //fname,lname
                            {
                                if($i == 0)
                                {
                                    if($this->firstname == '')
                                    {   
                                        $this->firstname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->firstname, $singleauthordata[$i]);
                                    }
    
                                    if($this->middlename == '')
                                    {   
                                        $this->middlename = array(null);
                                    }
                                    else
                                    {
                                        array_push($this->middlename, null);
                                    }
                                }
    
                                if($i == 1)
                                {
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, $singleauthordata[$i]);
                                    }
                                }
                            }
                            elseif($datacount == 1)
                            {
                                if($i == 0)
                                {
                                    if($this->firstname == '')
                                    {   
                                        $this->firstname = array($singleauthordata[$i]);
                                    }
                                    else
                                    {
                                        array_push($this->firstname, $singleauthordata[$i]);
                                    }
    
                                    if($this->middlename == '')
                                    {   
                                        $this->middlename = array(null);
                                    }
                                    else
                                    {
                                        array_push($this->middlename, null);
                                    }
    
                                    if($this->lastname == '')
                                    {   
                                        $this->lastname = array(null);
                                    }
                                    else
                                    {
                                        array_push($this->lastname, null);
                                    }
                                }
                            }
                        }
                    }
                }
            // }
    
            //Insert data in pubdtls table
            $lastNameCopy = '';
    
            if($this->lastname !== ""){
                if(count($this->lastname) > 1 ){
                    for($count = 0; $count < count($this->lastname); $count++ ){
                        $lastNameCopy = $lastNameCopy == '' ?  $this->lastname[$count] : $lastNameCopy . ' ' . $this->lastname[$count];
                    }
                }else{
                    $lastNameCopy = $this->lastname[0];
                }
            }
    
            for($count = 0; $count < count($this->firstname); $count++ )
            {
                if($this->middlename[$count]  != null)
                {
                    $fullname = $this->firstname[$count] . ' ' . $this->middlename[$count] . ' ' . $lastNameCopy;
                }
                else
                {
                    $fullname = $this->firstname[$count] . ' ' . $lastNameCopy;
                }
    
                $data = array(
                    'athrfirstname' => $this->firstname[$count],
                    'athrmiddlename' => $this->middlename[$count],
                    'athrlastname' => $lastNameCopy,
                    'fullname' => $fullname,
                    'pubhdrid' => $headermaxid,
                    'slno' =>  $pubdtls_slno
                );
            }
    
            return $data;
            
           } catch (Exception $ex)
           {       
               dd('Exception block', $ex);
           }
    }

    function duplication_check($title,$conference,$authors,$categoryid)
    {
        $pubhdrid = 0;

        $isauthor = 0;
        $pubdtls_author = '';
        $display_author = [];

        $titledata =  pubhdr::where('title',$title)->where('categoryid',$categoryid)
                        ->where('deleted','0')->get(['title']);

        if (count($titledata) > 0){
            $titledata =  pubhdr::where('title',$title)->where('categoryid',$categoryid)
                            ->where('deleted','0')->first()->title;
        }
        else
        {
            $titledata = null;
        }

        // $conferencedata = pubhdr::where('confname',$conference)->where('categoryid',$categoryid)
        //                     ->where('deleted','0')->get(['confname']);
        
        // if (count($conferencedata) > 0){
        //     $conferencedata = pubhdr::where('confname',$conference)->where('categoryid',$categoryid)
        //                         ->where('deleted','0')->first()->confname;
        // }
        // else
        // {
        $conferencedata = null;
        // }

        if($titledata != null && $conferencedata != null)
        {
            $pubhdrid = pubhdr::where('title',$title)
            ->where('confname',$conference)->where('categoryid',$categoryid)->where('deleted','0')->first()->id;
        }
        elseif ($titledata != null)
        {
            $pubhdrid = pubhdr::where('title',$title)->where('categoryid',$categoryid)->where('deleted','0')->first()->id;
        }
        elseif($conferencedata != null)
        {
            $pubhdrid = pubhdr::where('confname',$conference)->where('categoryid',$categoryid)->where('deleted','0')->first()->id;
        }

        if(count($this->dupId) === 0){
            $this->dupId = array($pubhdrid);
        }
        else
        {
            array_push($this->dupId, $pubhdrid);
        }

        // if($pubhdrid > 0)
        // {
        //     $pubdtls_slno_auth_data = 1;
        //     $verify_author_data = [];
        //     foreach ($authors as $author) {
        //         $verify_author_data[] = $this->author_display(0,$author,$pubdtls_slno_auth_data++, 0);
        //     }

        //     foreach ($verify_author_data as $key => $value) {
        //         $pubdtls_author = pubdtl::where('fullname',$value['fullname'])->first()->fullname;
                
        //         if($pubdtls_author != '')
        //         {
        //             $isauthor = $isauthor + 1;
        //             $display_author[] = $pubdtls_author;
        //             $pubdtls_author = '';
        //         }
        //     }
        // }

        if($pubhdrid > 0 || $isauthor > 0)
        {
            if($titledata == null){$titledata = '';}
            if($conferencedata == null){$conferencedata = '';}

            $get_data = array(
                //'pubhdrid' => $pubhdrid,
                'title' => $titledata,
                'conference' => $conferencedata,
                'category' => $categoryid == 7 ? 'Journal' : 'Conference/Workshop'
            );

            // $get_data = $titledata . ',' . $conferencedata;
        } 
        else
        {
            $get_data = []; 
        }

        session()->put('headerId', $this->dupId);

        return $get_data;
    }

    function get_file_data(Request $request)
    {
        $get_content = base64_decode($request->filedata);

        Session::forget('filedata');

        session()->put('filedata', $get_content);
    }

    private $display_dup = [];
    function display_duplicate_on_js()
    {
        $file_contents = session()->get('filedata');

        $get_conference = null;
        $get_title = '-';
        $get_authors = [];
        $dup = [];
        $output = '';

        // Create and configure a Listener
        $get_listener = new Listener();
        $get_listener->addProcessor(new Processor\TagNameCaseProcessor(CASE_LOWER));

        // Create a Parser and attach the listener
        $get_parser = new Parser();
        $get_parser->addListener($get_listener);

        $get_parser->parseString($file_contents); // or parseFile('/path/to/file.bib')
        $get_entries = $get_listener->export();

        foreach ($get_entries as $key => $value) {
            $get_arraykeys = array_keys($value);

            if(strtolower($value['type']) == "article" || strtolower($value['type']) == "misc" || strtolower($value['type']) == "journal")
            {
                // Fetch Category id for journal
                $get_categoryid = categories::where('category', 'journal')->first()->id;
            }

            if(strtolower($value['type']) == "conference" || strtolower($value['type']) == "inproceedings")
            {
                // Fetch Category id for conference
                $get_categoryid = categories::where('category', 'Conference/Workshop')->first()->id;
            }

            /***********Conference*************/
            if(in_array('journal',$get_arraykeys)){
                $get_conference = $value['journal'];
            }

            if(in_array('booktitle',$get_arraykeys)){
                $get_conference = $value['booktitle'];
            }

            if(in_array('conference',$get_arraykeys)){
                $get_conference = $value['conference'];
            }
            /***********Conference*************/

            /***********Title*************/
            if(in_array('booktitle',$get_arraykeys)){
                $get_title = $value['booktitle'];
            }

            if(in_array('title',$get_arraykeys)){
                $get_title = $value['title'];
            }
            /***********Title*************/

            /***********Author*************/
            if(in_array('author',$get_arraykeys)){
                if(str_contains($value['author'],"and"))
                {
                    $get_authors = array_map('trim', (explode("and" , $value['author'])));
                }
                else
                {
                    $get_authors = array_map('trim', (explode("," , $value['author'])));
                }
            }
            /***********Author*************/

            $this->display_dup[] = $this->duplication_check(trim($get_title),trim($get_conference),$get_authors,$get_categoryid);

            // foreach ($data as $val) {
            //     $output .= $val->title . ',' . $val->conference;
            // }
        }

        echo json_encode($this->display_dup);
        // return response()->json($dup); 
    }
}
