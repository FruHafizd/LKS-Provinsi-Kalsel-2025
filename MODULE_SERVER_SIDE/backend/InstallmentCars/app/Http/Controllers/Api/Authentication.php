<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Societies;
use Illuminate\Http\Request;

class Authentication extends Controller
{
    public function login(Request $request)
    {
        $request->validate(rules: [
            'id_card_number' => 'required',
            'password' => 'required'
        ]);

        $societies = Societies::with('regional')->where('id_card_number', $request->id_card_number)->first();

        if ($societies && $request->password && $societies->password) {
            $token = $societies->createToken('auth_token')->plainTextToken;

            return response()->json([
                'name' => $societies->name,
                'born_date' => $societies->born_date,
                'gender' => $societies->gender,
                'address' => $societies->address,
                'token' => $token,
                'regional' => [
                    'id' => $societies->regional->id,
                    'province' => $societies->regional->province,
                    'disctrict' => $societies->regional->disctrict,
                ]
            ], 200);
        }

        return response()->json([
            'message' => 'ID Card Number or Password incorrect'
        ],401);
    }

    public function logout(Request $request)  {
        $user = $request->user();
        
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json([
                'message' => 'Logout Success'
            ],200);
        }

        return response()->json([
            'message' => 'Invalid token'
        ],401);
    }

}
