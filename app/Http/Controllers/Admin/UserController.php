<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   

    public function __construct() {
        $this->middleware("auth");
        $this->middleware("can:edit-users");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::paginate(10);

        return view("admin.users.index", [
            "users" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(["name", "email", "password", "password_confirmation"]);

        $validator = Validator::make($data, [
            "name" => ["required", "string", "max:100"],
            "email" => ["required", "string", "email", "max:200", "unique:users"],
            "password" => ["required", "string", "min:4", "confirmed"]
        ]);

        if($validator->fails()) {
            return redirect()->route("users.create")
            ->withErrors($validator)
            ->withInput();
        }

        $data["password"] = Hash::make($data["password"]);
        $user = User::create($data);
        return redirect()->route("users.index");
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
        $user = User::find($id);

        if($user) {
            return view("admin.users.edit", [
                "user" => $user
            ]);
        }

        return redirect()->route("users.index");

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
        $user = User::find($id);
        if($user) {
            $data = $request->only([
                "name",
                "email",
                "password",
                "password_confirmation"
            ]);

            $validator = Validator::make([
                "name" => $data["name"],
                "email" => $data["email"]
            ], [
                "name" => ["required", "string", "max:100"],
                "email" => ["required", "email", "string", "max:100"]
            ]);

            if($validator->fails()) {
                return redirect()->route("users.edit", ["user" => $id])
                ->withErrors($validator);
            }

            $user->name = $data["name"];
            if($user->email != $data["email"]) {
                $hasEmail = User::where("email", $data["email"])->get();
                if(count($hasEmail) === 0) {
                    $user->email = $data["email"];
                } else {
                    $validator->errors()->add("email", __("validation.unique", [
                        "attribute" => "email" 
                    ]));                    
                }
            }

            if(!empty($data["password"])) {
                if($data["password"] === $data["password_confirmation"]) {
                    $user->password = Hash::make($data["password"]);
                } else {
                    $validator->errors()->add("password", __("validation.confirmed", [
                        "attribute" => "password",
                    ]));
                }
            }

            if(count($validator->errors()) > 0) {
                return redirect()->route("users.edit", ["user"=>$id])->withErrors($validator);
            }

            $user->save();

            $request->session()->flash("success", "Usuário alterado com sucesso!");

            return redirect()->route("users.edit", ["user" => $id]);
        }

        return redirect()->route("users.index");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedId = intval(Auth::id());

        if($loggedId !== intval($id)) {
            $user = User::find($id)->delete();
        }

        return redirect()->route("users.index");
    }
}
