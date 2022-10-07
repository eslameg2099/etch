<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Collect;
use App\Http\Controllers\Controller;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collects = Collect::query()
            ->whereNull('collected')
            ->groupBy('user_id')
            ->selectRaw('user_id, COUNT(order_id) as orders_count, SUM(amount) as total')
            ->get();

        //dd($collects->toArray());

        return view('dashboard.collects.index', compact('collects'));
    }

    public function show(User $user)
    {
        $uncollect = Collect::query()
            ->where('user_id', $user->id)
            ->whereNull('collected')
            ->groupBy('date')
            ->selectRaw('COUNT(order_id) as orders_count, SUM(amount) as total, DATE(created_at) date')
            ->get();


        $collected = Collect::query()
            ->where('user_id', $user->id)
            ->where('collected', true)
            ->groupBy('date')
            ->selectRaw('COUNT(order_id) as orders_count, SUM(amount) as total, DATE(created_at) date')
            ->get();

        return view('dashboard.collects.show', compact('uncollect', 'collected', 'user'));
    }

    public function collect(User $user, Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        Collect::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', $request->date)
            ->whereNull('collected')
            ->update([
                'collected' => true,
            ]);

        return back();
    }
}
