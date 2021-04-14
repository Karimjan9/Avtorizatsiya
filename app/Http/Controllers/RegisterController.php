<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\userstatuses;

class RegisterController extends Controller
{
    public function saveuser(Request $request){//admin, premium

        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:users'],
            'login'=> ['required','string','min:3','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user=new User;
        $user->name=$request->name;
        $user->login=$request->login;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

        return redirect('home')->with('status','User saved successfully!!!');
    }

    public function users(){//admin, premium -> editDisabled
        // $users=User::paginate(7);
        // $statuses=userstatuses::all();

        // $users = DB::select(DB::raw('select id, name, login, (select name from userstatuses where userstatuses.id = users.status) as status, email from users'));
        $users = DB::table('users')
                    ->join('userstatuses', 'userstatuses.id', '=','users.status')
                    ->select('users.id', 'users.name', 'users.login', 'users.email', 'userstatuses.name as status')
                    ->paginate(7);

        // $userstatus = array();
        // foreach ($statuses as $stat) {
        //     $status[$stat->id] = $stat->name;
        // }
        // array[index]=name;

        // return "<pre>".var_dump($status)."</pre>";

        return view('allusers')->with('users',$users);
        // ->with("userstatus", $status);
    }

    public function edituser($id){// admin
        $user=User::find($id);
        $stat=userstatuses::all();
        return view('userform')->with('user',$user)->with('stat',$stat);
    }
    public function changeuser($id, Request $request){//admin
        $request->validate([
            'name' => ['required', 'string', 'max:255','unique:users'],
            'login'=> ['required','string','min:3','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [ 'string', 'min:8', 'confirmed'],
        ]);
        
        $userchange=User::find($id);
        $userchange->name=$request->name;
        $userchange->login=$request->login;
        $userchange->email=$request->email;
        if(isset($request->password)){
            $userchange->password=Hash::make($request->password);
        }
        $userchange->save();
        return redirect('/u')->with('success',"User has been changed!!!");
    }
}
