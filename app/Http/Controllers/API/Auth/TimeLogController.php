<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TimeLog;
use Illuminate\Support\Facades\Validator;
use App\Exports\LogsExport;
use Maatwebsite\Excel\Facades\Excel;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $logs = TimeLog::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return response()->json([
            'success' => true,
            'message' => 'Time Logs',
            'data' => $logs
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
                'start_time' => 'required',
                'end_time' => 'required',
                'description' => 'required',
                ]);
        $log = new TimeLog([
                'user_id' => auth()->user()->id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'description' => $request->description,
                ]);
        $log->save();
        return response()->json([
            'success' => true,
            'message' => 'Time Log Created',
            'data' => $log
        ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function manualEntry(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'start_time' => 'required',
                'end_time' => 'required',
                'description' => 'required',
                ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            return response()->json(['message' => $firstError], 400);
        }

        $seconds_duration = strtotime($request->end_time) - strtotime($request->start_time);
        $hours_duration = intval($seconds_duration / 3600);

        $log = new TimeLog([
                'user_id' => $request->user_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'description' => $request->description,
                'duration' => $hours_duration,
                ]);

        $log->save();

        return response()->json([
            'success' => true,
            'message' => 'Time Log Created',
            'data' => $log
        ], 201);
    }

    public function exportExcel() {
        return Excel::download(new LogsExport, 'logs.xlsx');
    }


}
