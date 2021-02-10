<?php

namespace App\Http\Controllers;
use DB;

use Illuminate\Http\Request;

class ViewController extends Controller
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

        return view('Publication.view')->with("categoryData",$categoryData);
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

    public function showviewauthor(Request $request)
    {
        if($request->ajax())
        {
            $output = '';

            $query = $request->get('query');
            if($query != '')
            {
                $data = DB::table('pubdtls')
                    ->select('fullname')
                    ->join("pubhdrs",function($join){
                        $join->on("pubhdrs.id","=","pubdtls.pubhdrid")
                            ->where('pubhdrs.deleted','=','0');
                    })
                    ->where('fullname','like','%' .$query. '%')
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
                    $output .= '<tr><td style="border-top: none; border-left: none; cursor: context-menu;" id="athrfirstname" name="fullname[]">' . $row->fullname . '</td></tr>';           
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

    public function getviewsearchresult(Request $request){
        $fromdt = $request->get('frmdate');
        $todt = $request->get('todate');
        $author = $request->get('author');
        $category = $request->get('category');

        $data =  DB::select('call Get_Search_View_Data (?,?,?,?)', 
                array($fromdt,$todt,$author,$category));

        $output = '';
        
        if(!empty($data))
        {
            foreach($data as $row)
            {
                $output .= '<tr>
                <td>' . $row->publicationdate . '</td>
                <td>' . $row->category . '</td>
                <td>' . $row->authorname . '</td>
                <td>' . $row->title . '</td>
                <td>' . $row->confname . '</td>
                <td style="text-align: center;"><a target="_blank" href='. url('publicationview/'.base64_encode($row->hdrid)) .'><img id="imgview" src="../image/eye_icon.png"></a></td>
                <td style="display: none;">' . $row->hdrid . '</td>';
            }
        }

        return $output;
    }
}
