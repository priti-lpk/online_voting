<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Session;
use Validator;
use Auth;
use Hash;

class LoginController extends Controller {

    function index() {
        return view('login');
    }

    function checklogin(Request $request) {
        $name = $request->input('email_id');
        $pass = $request->input('password');
        $session = $request->session()->get('email_id');
        $data = DB::select('select id from user_table where status=? and email_id=? and password=?', ['true', $name, $pass]);
        if ($data == Array()) {
            
        } else {
            $request->session()->put('userid', $data[0]->id);
        }
        if (count($data)) {
               return redirect('dashboard');
        } else {
            return redirect()->back()->with('message', 'Authentication Fail');
        }
    }

    function dashboard() {
        return view('dashboard');
    }

    function add_register(Request $request) {
        $getdata = DB::select('select * from user_table');
        if (empty($getdata)) {
            $user = 1;
        } else {
            foreach ($getdata as $g) {
                $user = $g->id + 1;
            }
        }
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email_id = $request->input('email_id');
        $password = Hash::make($request->input('password'));
//        print_R($password);
        $data1 = array('firstname' => $firstname, "lastname" => $lastname, "email_id" => $email_id, "password" => $password, "status" => 'true');
        DB::table('user_table')->insert($data1);
        $data = [
        'from' => 'talk@lpktechnosoft.com',
        'subject' => 'Your Hash Key',
        'email' => $request->input('email_id'),
        'password' => $password,
        ];
        Mail::to($email_id)->send(new TestEmail($data));
        return redirect('/');
    }

    function change_password(Request $request) {
        return view('change_password');
    }

    function change(Request $request) {
        $input = $request->all();
        $getdata = DB::table('admin')
                ->where('username', $input['id'])
                ->get();
        $user = '';
        foreach ($getdata as $g) {
            $user = $g->password;
        }
        if ($user == md5($input['old'])) {
            return "1";
        } else {
            return "0";
        }
    }

    function change_pass(Request $request) {
        $input = $request->all();
        $pass = DB::table('admin')->where('username', $input['change'])->update(['password' => md5($input['new'])]);
        if ($pass == TRUE) {
            return '1';
        } else {
            return '0';
        }
    }

    function user_profile(Request $request) {
        $user = session()->get('userid');
        $getdata = DB::table('user_table')
                ->where('id', $user)
                ->get();
        return view('user_profile', ['getdata' => $getdata]);
    }

    function edit_user(Request $request, $id) {
        $pass = DB::table('user_table')->where('id', $id)->update(['email_id' => $request->input('email_id'), 'firstname' => $request->input('firstname'), 'lastname' => $request->input('lastname')]);
        return redirect('change_user_profile');
    }

}
