<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function index() {
        $settings = []; 

        $dbsettings = Setting::all();

        foreach($dbsettings as $dbsetting) {
            $settings[$dbsetting->name] = $dbsetting->content;
        } 

        return view("admin.settings.index", [
            "settings" => $settings
        ]);
    }

    public function update(Request $request) {
        $data = $request->only([
            "title", "subtitle", "email", "bgcolor", "textcolor"
        ]);

        $validator = $this->validator($data);

        if($validator->fails()){
            return redirect()->route("settings")->withErrors($validator);
        }
        
        foreach($data as $item => $value) {
            Setting::where('name', $item)->update([
                "content" => $value
            ]);
        }

        return redirect()->route("settings")->with("success", "Alterações efetuadas com sucesso!");

    }

    private function validator($data) {
        return Validator::make($data, [
            "title" => ["string", "max:100"],
            "subtitle" => ["string", "max:100"],
            "email" => ["email", "string", "max:100"],
            "bgcolor" => ["string", 'regex:/#[A-f0-9]{6}/i'],
            "textcolor" => ["string", "regex:/#[A-f0-9]{6}/i"]
        ]);
    }
}
