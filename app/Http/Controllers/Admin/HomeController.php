<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Visitor;
use App\User;
use App\Page;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {    
        $periodQuery = $request->query("period", 30);
        
        $visitsCount = 0;
        $onlineCount = 0;
        $pageCount = 0;
        $userCount = 0;

        // Contagem de visitantes
        $period = date('Y-m-d H:i:s', strtotime("- {$periodQuery} days"));
        $visitsCount = Visitor::where("created_at", ">=", $period)->count();

        // Contagem de usuários online
        $datelimit = date('Y-m-d H:i:s', strtotime("-5 minutes"));
        $onlinelist = Visitor::select("ip")->where("created_at", ">=", $datelimit)->groupBy("ip")->get();
        $onlineCount = count($onlinelist);

        $pageCount = Page::count();
        $userCount = User::count();        

        // contagem para o page pie
        $pagePie = [];
        $visitsAll = Visitor::selectRaw("page, count(page) as c")
            ->where('created_at', ">=", $period)
            ->groupBy("page")
            ->get();
        foreach($visitsAll as $visit) {
            $pagePie[$visit['page']] = intval($visit["c"]);
        }
        $pages = Page::all();
        foreach($pages as $key => $value) {

        }

        $pageLabels = json_encode(array_keys($pagePie));
        $pageValues = json_encode(array_values($pagePie));

        return view('admin.home', [
            "visitsCount" => $visitsCount,
            "onlineCount" => $onlineCount,
            "pageCount" => $pageCount,
            "userCount" => $userCount,
            "pageLabels" => $pageLabels,
            "pageValues" => $pageValues
        ]);
    }
}
