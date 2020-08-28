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

    function index(Request $request) {
        $pos = $request->input('position_id');
        $position = DB::table('position_table')
                ->select('position_table.id', 'position_table.position_name')
                ->join('election_table', 'position_table.election_id', '=', 'election_table.id')
                ->where('election_type', 'public')
                ->get();
        return view('public', ['position' => $position, 'pos_id' => $pos]);
    }

    function add_vote(Request $request) {
        $position_id = $request->input('position_id');
        $candidates_id = $request->input('candidates_id');
        $mac_address = $request->input('mac_address');

        $data = array('position_id' => $position_id, "candidates_id" => $candidates_id, "mac_address" => $mac_address);
        DB::table('voting_table')->insert($data);
        $q = DB::table('voting_table')->toSql();
        return back()->withInput();
    }

}
