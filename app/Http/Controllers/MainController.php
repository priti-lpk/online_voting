<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use Validator;
use Auth;

class MainController extends Controller {

    function voting(Request $request) {
        $pos = $request->input('position_id');
        $position = DB::table('position_table')
                ->select('position_table.id', 'position_table.position_name')
                ->join('election_table','position_table.election_id','=','election_table.id')
                ->where('election_type','private')
                ->get();
        return view('voting', ['position' => $position, 'pos_id' => $pos]);
    }

    function add_vote(Request $request) {
        $position_id = $request->input('position_id');
        $candidates_id = $request->input('candidates_id');
        $user_id = $request->input('user_id');
        $mac_address = $request->input('mac_address');

        $data = array('position_id' => $position_id, "candidates_id" => $candidates_id, "user_id" => $user_id);
        DB::table('voting_table')->insert($data);
        $q = DB::table('voting_table')->toSql();
        return back()->withInput();
    }

    function get_candidate(Request $request, $id) {
        $getdata = DB::select('select * from candidates_table where id = ?', [$id]);
        $candidate = DB::table('candidates_table')
                ->select('candidates_table.id', 'position_table.position_name', 'candidates_table.first_name', 'candidates_table.last_name', 'candidates_table.image', 'candidates_table.symbol')
                ->join('position_table', 'candidates_table.position_id', '=', 'position_table.id')
                ->get();
        $position = DB::table('position_table')->select('id', 'position_name')->get();
        return view('candidate', ['position' => $position, 'candidate' => $candidate, 'getdata' => $getdata]);
    }

    function edit_candidate(Request $request, $id) {
        $position = $request->input('position_id');
        $fname = $request->input('first_name');
        $lname = $request->input('last_name');
        $file = $request->file('image');

        if ($files = $request->file('image')) {
            $destinationPath = base_path('\CandidatesImage'); // upload path
            $profileImage = $id . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
            $insert['image'] = "$profileImage";
        }
        if ($sfiles = $request->file('symbol')) {
            $sdestinationPath = base_path('\CandidatesSymbol'); // upload path
            $sprofileImage = $id . "." . $sfiles->getClientOriginalExtension();
            $sfiles->move($sdestinationPath, $sprofileImage);
            $sinsert['symbol'] = "$sprofileImage";
        }
        DB::update('update candidates_table set position_id = ?,first_name=?,last_name=?,image=?,symbol=? where id = ?', [$position, $fname, $lname, "CandidatesImage/" . $profileImage, "CandidatesSymbol/" . $sprofileImage, $id]);
        return back()->withInput();
    }

    function del_candidate(Request $request, $id) {
        $getdata = DB::table('candidates_table')
                ->where('id', $id)
                ->get();
        foreach ($getdata as $g) {
            $user = $g->image;
            $symbol = $g->symbol;
        }
        $image_path = $user;
        $image_path1 = $symbol;
        if (file_exists($image_path) && file_exists($image_path1)) {
            @unlink($image_path);
            @unlink($image_path1);
            DB::delete('delete from candidates_table where id = ?', [$id]);
            return redirect('candidate');
        }
    }

}
