<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Validation as ModelsValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Validation extends Controller
{
    public function createValidation(Request $request)  {
        $validator = Validator::make($request->all(),[
            'job' => 'required',
            'job_description' => 'required',
            'income' => 'required',
            'reason_accepted' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'errors' => $validator->errors()
            ],400);
        }

        if (ModelsValidation::where('society_id',  $request->user()->id)->exists()) {
            return response()->json([
                'message' => 'You already submitted a validation request.'
            ],400);
        }

        ModelsValidation::create([
            'society_id' => $request->user()->id,
            'job' => $request->job,
            'job_description' => $request->job_description,
            'income' => $request->income,
            'reason_accepted' => $request->reason_accepted,
        ]);

        return response()->json([
            'message' => 'Request data validation sent successful'
        ],200);
    }

    public function getSocietyDataValidation(Request $request) {
        $validation = ModelsValidation::with('validator')->where('society_id', $request->user()->id)->first([
            'id', 'status', 'job', 'job_description', 'income', 'reason_accepted', 'validator_notes','validator_id'
        ]);

        if (!$validation) {
            return response()->json([
                'message' => 'Data validation not found!'
            ], 404);
        }

        return response()->json([
            'validation' => [
                'id' => $validation->id,
                'status' => $validation->status,
                'job' => $validation->job ?? null,
                'job_description' => $validation->job_description ?? null,
                'income' => $validation->income ?? null,
                'reason_accepted' => $validation->reason_accepted ?? null,
                'validator_notes' => $validation->validator_notes ?? null,
                'validator' => $validation->validator_id ? [
                    'id' => $validation->validator->id,
                    'name' => $validation->validator->name,
                    'role' => $validation->validator->role,
                ] : null
            ]
        ], 200);
    }



}
