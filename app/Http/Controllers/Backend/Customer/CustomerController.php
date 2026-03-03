<?php

namespace App\Http\Controllers\Backend\Customer;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function customerList()
    {
        $users = User::wherenotin('id', [4, 5])->where('role_id', Roles::Dealer)->get();
        return view('backend.admin.customer.customer', compact('users'));
    }

    function customerData()
    {
        $data = UserLogin::join('users as u', 'u.id', '=', 'user_logins.user_id')
            ->select('u.name', 'u.mobile', 'u.zone', 'user_logins.login_at', 'user_logins.last_activity')
            ->whereNull('user_logins.logout_at')
            ->where('user_logins.last_activity', '>=', now()->subMinutes(15))
            ->orderBy('user_logins.last_activity', 'desc');

        return datatables()->of($data)->make(true);
    }

    function customerLogData(Request $request)
    {
        $data = UserLogin::join('users as u', 'u.id', '=', 'user_logins.user_id')
            ->select(
                'u.id',
                'u.name',
                'u.mobile',
                'u.zone',
                'user_logins.login_at',
                'user_logins.logout_at'
            )
            ->whereNotNull('user_logins.logout_at');   // 🔴 Only logged out users

        // 🔵 filter by user
        if ($request->user_id && $request->user_id != 'all') {
            $data->where('u.id', $request->user_id);
        }

        // 🔵 filter by date range
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $from = Carbon::parse($request->from_date)->startOfDay();
            $to   = Carbon::parse($request->to_date)->endOfDay();

            $data->whereBetween('user_logins.login_at', [$from, $to]);
        }

        $data->orderBy('user_logins.login_at', 'desc');

        return datatables()->of($data)
            ->editColumn('login_at', function ($row) {
                return $row->login_at
                    ? Carbon::parse($row->login_at)->format('d-m-Y h:i A')
                    : '-';
            })
            ->editColumn('logout_at', function ($row) {
                return $row->logout_at
                    ? Carbon::parse($row->logout_at)->format('d-m-Y h:i A')
                    : '-';
            })
            ->make(true);
    }
}
