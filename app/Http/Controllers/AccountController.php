<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


use App\Account;
use App\User;

use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
    return redirect('/users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate( $request, [
            'email' => 'required',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'avatar' => 'required'
        ] );

        $account = new Account( [
            'email' => $request -> get( 'email' ),
            'password' => Hash::make( $request -> get( 'password' ) ),
        ] );
        $account -> save();

        $user = new User( [
            'firstname' => $request -> get( 'firstname' ),
            'lastname' => $request -> get( 'lastname' ),
            'avatar' => $request -> get( 'avatar' ),
            'account_id' => $account -> id
        ] );
        $user -> save();

        return redirect( '/accounts' ) -> with( 'success', 'Account has been added' );
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $accountObj = Account::find($id);
        // dd($accountObj);
        $users = User::where("account_id", "=", $id)->get();
        return view('accounts.show', compact('accountObj', 'users'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $account = Account::find($id);
        return view('accounts.edit',compact('account'));

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

        $request->validate([
            'email' => 'required',
            // 'password' => 'required',

        ]);

        $account = Account::find($id);
        $account->email = $request->get('email');
        if($request->get('password')){
            $account->password = Hash::make($request->get('password'));
        }
        $account->save();

        return redirect()->route('accounts.index')->with('success','Account updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::find($id);
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'This account has been deleted');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
