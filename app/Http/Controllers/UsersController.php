<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\APIMaintenance;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.users', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.user')->with('user', $user);
    }

    /**
     * Send notification
     *
     * @return \Illuminate\Http\Response
     */
    public function sendNotification(Request $request)
    {
        $users = User::where('role','user')->get();

        foreach($users as $user) {
            Mail::to($user->email)->send(new APIMaintenance($user->name, $request));
        }

        if(Mail::failures()===[]){
            return "Mail(s) sent";
        }

        return Mail::failures();
    }
}
