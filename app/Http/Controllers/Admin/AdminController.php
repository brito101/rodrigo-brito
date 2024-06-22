<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\User;
use App\Models\Views\User as ViewsUser;
use App\Models\Views\Visit;
use App\Models\Views\VisitYesterday;
use Illuminate\Http\Request;
use DataTables;
use Shetabit\Visitor\Models\Visit as ModelsVisit;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $administrators = ViewsUser::where('type', 'Administrador')->count();

        $posts = Blog::all();

        foreach ($posts as $post) {
            $post->content = str_replace("https://www.dev.rodrigobrito.dev.br" , "https://www.rodrigobrito.dev.br" , $post->content);
        }


        $posts = Blog::select('id', 'status', 'title', 'views', 'created_at')->orderBy('created_at', 'desc')->get();
        $projects = Portfolio::select('id', 'status', 'title', 'views', 'created_at')->orderBy('created_at', 'desc')->get();
        $certificates = Certificate::select('id', 'status', 'created_at')->orderBy('created_at', 'desc')->get();

        $visitors = ModelsVisit::select('url', 'created_at', 'ip')->where('url', '!=', route('admin.home.chart'))
            ->where('url', 'NOT LIKE', '%columns%')
            ->where('url', 'NOT LIKE', '%storage%')
            ->where('url', 'NOT LIKE', '%admin%')
            ->where('url', 'NOT LIKE', '%offline%')
            ->where('url', 'NOT LIKE', '%logout%')
            ->where('url', 'NOT LIKE', '%manifest.json%')
            ->where('url', 'NOT LIKE', '%.png%')
            ->whereRaw('created_at >= DATE_SUB(CURDATE(), INTERVAL 10 DAY)')
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->day;
            });

        $visits = Visit::where('url', '!=', route('admin.home.chart'))
            ->where('url', 'NOT LIKE', '%columns%')
            ->where('url', 'NOT LIKE', '%storage%')
            ->where('url', 'NOT LIKE', '%admin%')
            ->where('url', 'NOT LIKE', '%offline%')
            ->where('url', 'NOT LIKE', '%logout%')
            ->where('url', 'NOT LIKE', '%manifest.json%')
            ->where('url', 'NOT LIKE', '%.png%')
            ->get();


        // $postsList = $posts->orderBy('views', 'desc')->limit(25);
        $postsChart = ['label' => [], 'data' => []];
        foreach ($posts->sortBy('views')->reverse()->take(10) as $p) {
            $postsChart['label'][] = Str::limit($p->title, 25);
            $postsChart['data'][] = (int)$p->views;
        }

        // $projectsList = $projects->orderBy('views', 'desc')->limit(25);

        $projectsChart = ['label' => [], 'data' => []];
        foreach ($projects->sortBy('views')->reverse()->take(10) as $p) {
            $projectsChart['label'][] = Str::limit($p->title, 25);
            $projectsChart['data'][] = (int)$p->views;
        }

        if ($request->ajax()) {
            return Datatables::of($visits)
                ->addColumn('time', function ($row) {
                    return date(('H:i:s'), strtotime($row->created_at));
                })
                ->addIndexColumn()
                ->rawColumns(['time'])
                ->make(true);
        }

        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return view('admin.home.index', compact(
            'visitors',
            'administrators',
            'posts',
            'projects',
            'certificates',
            'onlineUsers',
            'percent',
            'access',
            'chart',
            'projectsChart',
            'postsChart'
        ));
    }

    public function chart()
    {
        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return response()->json([
            'onlineUsers' => $onlineUsers,
            'access' => $access,
            'percent' => $percent,
            'chart' => $chart
        ]);
    }

    private function accessStatistics()
    {
        $onlineUsers = User::online()->count();

        $accessToday = Visit::where('url', '!=', route('admin.home.chart'))
            ->where('url', 'NOT LIKE', '%columns%')
            ->where('url', 'NOT LIKE', '%storage%')
            ->where('url', 'NOT LIKE', '%admin%')
            ->where('url', 'NOT LIKE', '%offline%')
            ->where('url', 'NOT LIKE', '%logout%')
            ->where('url', 'NOT LIKE', '%manifest.json%')
            ->where('url', 'NOT LIKE', '%.png%')
            ->where('method', 'GET')
            ->get();
        $accessYesterday = VisitYesterday::where('url', '!=', route('admin.home.chart'))
            ->where('url', 'NOT LIKE', '%columns%')
            ->where('url', 'NOT LIKE', '%storage%')
            ->where('url', 'NOT LIKE', '%admin%')
            ->where('url', 'NOT LIKE', '%offline%')
            ->where('url', 'NOT LIKE', '%logout%')
            ->where('url', 'NOT LIKE', '%manifest.json%')
            ->where('url', 'NOT LIKE', '%.png%')
            ->where('method', 'GET')
            ->count();

        $totalDaily = $accessToday->count();

        $percent = 0;
        if ($accessYesterday > 0 && $totalDaily > 0) {
            $percent = number_format((($totalDaily - $accessYesterday) / $totalDaily * 100), 2, ",", ".");
        }

        /** Visitor Chart */
        $data = $accessToday->groupBy(function ($reg) {
            return date('H', strtotime($reg->created_at));
        });

        $dataList = [];
        foreach ($data as $key => $value) {
            $dataList[$key . 'H'] = count($value);
        }

        $chart = new \stdClass();
        $chart->labels = (array_keys($dataList));
        $chart->dataset = (array_values($dataList));

        return array(
            'onlineUsers' => $onlineUsers,
            'access' => $totalDaily,
            'percent' => $percent,
            'chart' => $chart
        );
    }
}
