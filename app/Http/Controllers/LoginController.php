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
        $pass = md5($request->input('password'));
        $session = $request->session()->get('email_id');
        $data = DB::select('select id from user_table where status=? and email_id=? and password=? and verify_status=?', ['true', $name, $pass, 'True']);
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
        $password = md5($request->input('password'));
        $otp = rand(100000, 999999);
        $data1 = array('firstname' => $firstname, "lastname" => $lastname, "email_id" => $email_id, "password" => $password, "status" => 'true', "verify_no" => $otp);
        DB::table('user_table')->insert($data1);
        $data = [
            'from' => 'talk@lpktechnosoft.com',
            'subject' => 'Your Verify no.',
            'email' => $request->input('email_id'),
            'otp' => $otp,
        ];
        Mail::to($email_id)->send(new TestEmail($data));
        return redirect('/');
    }

    function change_password(Request $request) {
        return view('change_password');
    }

    function change(Request $request) {
        $input = $request->all();
        $getdata = DB::table('user_table')
                ->where('id', $input['id'])
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
        $pass = DB::table('user_table')->where('id', $input['change'])->update(['password' => md5($input['new'])]);
        if ($pass == TRUE) {
            $getdata = DB::table('user_table')
                    ->where('id', $input['change'])
                    ->get();
            foreach ($getdata as $g) {
                $email_id = $g->email_id;
            }
//            $data = [
//                'from' => 'talk@lpktechnosoft.com',
//                'subject' => 'Your Hash Key',
//                'email' => $email_id,
//                'password' => md5($input['new']),
//            ];
////            print_r($data);
//            Mail::to($email_id)->send(new TestEmail($data));
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
