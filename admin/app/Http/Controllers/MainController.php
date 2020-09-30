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

    function election() {
        $election = DB::table('election_table')->select('id', 'election_name', 'election_type')->get();
        return view('election', ['election' => $election]);
    }

    function add_election(Request $request) {
        $election = $request->input('election_name');
        $type = 'Private';
        $data = array('election_name' => $election, 'election_type' => $type);
        DB::table('election_table')->insert($data);
        $q = DB::table('election_table')->toSql(); // Enable query log
        return back()->withInput();
    }

    function get_election(Request $request, $id) {
        $getdata = DB::select('select * from election_table where id = ?', [$id]);
        $election = DB::table('election_table')->select('id', 'election_name', 'election_type')->get();
        return view('election', ['election' => $election, 'getdata' => $getdata]);
    }

    function edit_election(Request $request, $id) {
        $position = $request->input('election_name');
        $type = 'Private';
        DB::update('update election_table set election_name = ?,election_type=? where id = ?', [$position, $type, $id]);
        return redirect('election');
    }

    function del_election(Request $request, $id) {
        DB::delete('delete from election_table where id = ?', [$id]);
        return redirect('election');
    }

    function position() {
        $election = DB::table('election_table')->select('id', 'election_name')->get();
        $position = DB::table('position_table')->select('position_table.id', 'position_table.position_name', 'election_table.election_name')
                        ->join('election_table', 'position_table.election_id', '=', 'election_table.id')->get();
        return view('position', ['position' => $position, 'election' => $election]);
    }

    function add_position(Request $request) {
        $election = $request->input('election_id');
        $position = $request->input('position_name');
        $data = array('election_id' => $election, 'position_name' => $position);
        DB::table('position_table')->insert($data);
        $q = DB::table('position_table')->toSql(); // Enable query log
        return back()->withInput();
    }

    function get_position(Request $request, $id) {
        $election = DB::table('election_table')->select('id', 'election_name')->get();
        $getdata = DB::select('select * from position_table where id = ?', [$id]);
        $position = DB::table('position_table')->select('position_table.id', 'position_table.position_name', 'election_table.election_name')
                        ->join('election_table', 'position_table.election_id', '=', 'election_table.id')->get();
        return view('position', ['position' => $position, 'getdata' => $getdata, 'election' => $election]);
    }

    function edit_position(Request $request, $id) {
        $election = $request->input('election_id');
        $position = $request->input('position_name');
        DB::update('update position_table set election_id=?,position_name = ? where id = ?', [$election, $position, $id]);
        return redirect('position');
    }

    function del_position(Request $request, $id) {
        DB::delete('delete from position_table where id = ?', [$id]);
        return redirect('position');
    }

    function candidate() {
        $candidate = DB::table('candidates_table')
                ->select('candidates_table.id', 'candidates_table.position_id', 'position_table.position_name', 'candidates_table.first_name', 'candidates_table.last_name', 'candidates_table.image', 'candidates_table.symbol')
                ->join('position_table', 'candidates_table.position_id', '=', 'position_table.id')
                ->get();
        $position = DB::table('position_table')->select('id', 'position_name')->get();
        return view('candidate', ['position' => $position, 'candidate' => $candidate]);
    }

    function add_candidate(Request $request) {
//        $getdata = DB::select('select * from candidates_table order by id desc limit 1');
//        if (empty($getdata)) {
//            $user = 1;
//        } else {
//            foreach ($getdata as $g) {
//                $user = $g->id + 1;
//            }
//        }
        $position = $request->input('position_id');
        $fname = $request->input('first_name');
        $lname = $request->input('last_name');
        $file = $request->file('image');
        $file1 = $request->file('symbol');
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,PNG|max:2048',
        ]);
        //get last id
        $lastdata = DB::table('candidates_table')->get()->last();
//        print_r($lastdata);
        if (empty($lastdata->id)) {
            $imageName = 1 . '.' . $file->getClientOriginalExtension();
        } else {
            $imageName = $lastdata->id + 1 . '.' . $file->getClientOriginalExtension();
        }
        $file->move(base_path('CandidatesImage'), $imageName);
        if (empty($lastdata->id)) {
            $imageName1 = 1 . '.' . $file1->getClientOriginalExtension();
        } else {
            $imageName1 = $lastdata->id + 1 . '.' . $file1->getClientOriginalExtension();
        }
        $file1->move(base_path('CandidatesSymbol'), $imageName1);
//        if ($files = $request->file('image')) {
//            $destinationPath = base_path('\CandidatesImage'); // upload path
//            $profileImage = $user . "." . $files->getClientOriginalExtension();
//            $files->move($destinationPath, $profileImage);
//            $insert['image'] = "$profileImage";
//        }
//        if ($sfiles = $request->file('symbol')) {
//            $sdestinationPath = base_path('\CandidatesSymbol'); // upload path
//            $sprofileImage = $user . "." . $sfiles->getClientOriginalExtension();
//            $sfiles->move($sdestinationPath, $sprofileImage);
//            $sinsert['symbol'] = "$sprofileImage";
//        }
        $data = array('position_id' => $position, "first_name" => $fname, "last_name" => $lname, "image" => "CandidatesImage/" . $imageName, "symbol" => "CandidatesSymbol/" . $imageName1);
        DB::table('candidates_table')->insert($data);
        $q = DB::table('candidates_table')->toSql();
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
        $file1 = $request->file('symbol');
        if (empty($file) && empty($file1)) {
            DB::update('update candidates_table set position_id = ?,first_name=?,last_name=? where id = ?', [$position, $fname, $lname, $id]);
        } else {
            if (empty($file)) {
                $imageName1 = $id . '.' . $file1->getClientOriginalExtension();
                $file1->move(base_path('CandidatesSymbol'), $imageName1);
                DB::update('update candidates_table set position_id = ?,first_name=?,last_name=?,symbol=? where id = ?', [$position, $fname, $lname, "CandidatesSymbol/" . $imageName1, $id]);
            } if (empty($file1)) {
                $imageName = $id . '.' . $file->getClientOriginalExtension();
                $file->move(base_path('CandidatesImage'), $imageName);
                DB::update('update candidates_table set position_id = ?,first_name=?,last_name=?,image=? where id = ?', [$position, $fname, $lname, "CandidatesImage/" . $imageName, $id]);
            } if ($file && $file1) {
                $imageName = $id . '.' . $file->getClientOriginalExtension();
                $file->move(base_path('CandidatesImage'), $imageName);
                $imageName1 = $id . '.' . $file1->getClientOriginalExtension();
                $file1->move(base_path('CandidatesSymbol'), $imageName1);
                DB::update('update candidates_table set position_id = ?,first_name=?,last_name=?,image=?,symbol=? where id = ?', [$position, $fname, $lname, "CandidatesImage/" . $imageName, "CandidatesSymbol/" . $imageName1, $id]);
            }
        }
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

    function view_result() {
        $getdata = DB::table('voting_table')
                ->select(DB::raw('COUNT(voting_table.position_id) as position'), 'candidates_table.first_name', 'candidates_table.last_name', 'position_table.position_name')
                ->join('candidates_table', 'candidates_table.id', '=', 'voting_table.candidates_id')
                ->join('position_table', 'voting_table.position_id', '=', 'position_table.id')
                ->groupby('voting_table.position_id')
                ->get();
//        $getdata = DB::select('SELECT COUNT(voting_table.position_id) as position,candidates_table.first_name,candidates_table.last_name FROM voting_table LEFT JOIN candidates_table ON voting_table.candidates_id=candidates_table.id GROUP BY candidates_table.position_id');
        return view('view_result', ['getdata' => $getdata]);
    }

    function view_user() {
        $getdata = DB::table('user_table')
                ->select('user_table.id', 'user_table.firstname', 'user_table.lastname', 'user_table.email_id', 'user_table.status')
                ->get();
        return view('view_user', ['getdata' => $getdata]);
    }

    function changestatus(Request $request) {
        $id = $request->input('cid');
        $status = $request->input('status');
        $data = DB::update('update user_table set status = ? where id = ?', [$status, $id]);
        if ($data == TRUE) {
            return 1;
        } else {
            return 0;
        }
    }

}
