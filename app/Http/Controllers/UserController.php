<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function login()
    {
        return view("auth.login");
    }
    public function register()
    {
        return view("auth.register");
    }
    public function profile(Request $request)
    {
        $user = User::where("id", session("LoggedUser"))->first();
        if ($request->isMethod('POST')) {
            // req came thorough form


            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:4',
                'phone' => 'required|string|min:10|max:20',
                'password' => 'nullable|string|min:5'
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // update the user
            $user->name = $request->name;
            $user->phone = $request->phone;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            // return back to profile page
            return to_route('profile')->with('success', 'Updated Successfully');
        }
        return view("profile", compact("user"));
    }

    public function dashboard()
    {
        $userId = session("LoggedUser");
        $user = User::where("id", $userId)->first();

        // Get data for the last 10 days
        $documentsPerDay = File::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subDays(10))
            ->groupBy('date')
            ->orderBy(
                'date',
                'asc'
            )
            ->get()
            ->keyBy('date')
            ->toArray();


        // Create an array with the last 10 days
        $dates = [];
        for (
            $i = 9;
            $i >= 0;
            $i--
        ) {
            $date = now()->subDays($i)->toDateString();
            $dates[] = $date;
        }

        // Ensure every day has a count value
        $documentsPerDayData = [];
        foreach ($dates as $date) {
            $documentsPerDayData[] = [
                'date' => $date,
                'count' => $documentsPerDay[$date]['count'] ?? 0,
            ];
        }

        // Total files uploaded by the user
        $totalFilesUploaded = File::where('user_id', $userId)->count();

        // Date of the first upload by the user
        $firstUploadDate = File::where('user_id', $userId)->orderBy('created_at', 'asc')->value('created_at');

        // Get total uploaded today
        $totalUploadedToday = File::where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // User account details
        $memberFrom = $user->created_at;
        $lastUpdated = $user->updated_at;

        return view('dashboard', compact('documentsPerDayData', 'totalFilesUploaded', 'firstUploadDate', 'memberFrom', 'lastUpdated', 'totalUploadedToday'));
    }
}
