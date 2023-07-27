<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use Validator;

class ReportsController extends Controller
{
    public function __construct() {
        auth()->setDefaultDriver('api');
        $this->middleware('auth:api');
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $report = Reports::create(array_merge(
            $validator->validated(),
        ));

        return response()->json([
            'message' => 'Report successfully created',
            'report' => $report
        ], 201);
    }

    public function list() {
        $reports = Reports::all();
        return response()->json([
            'reports' => $reports,
        ], 201);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $report = Reports::findOrFail($id);
        if($report) {
            $report = $report->update(array_merge(
                $validator->validated(),
            ));
            return response()->json([
                'report' => $report,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error',
            ], 201);
        }
    }

    public function delete($id) {
        $report = Reports::findOrFail($id);
        if($report) {
            $report->delete();
            return response()->json([
                'message' => 'Report successfully deleted',
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error',
            ], 201);
        }
    }

    public function show($id) {
        $report = Reports::findOrFail($id);
        if($report) {
            return response()->json([
                'report' => $report,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error',
            ], 201);
        }
    }
}
