<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Installment extends Controller
{
  public function getAllInstallmentCars(Request $request)
    {
        $installments = \App\Models\Installment::with(['brand', 'avaibleMonth'])->get();

        $data = [];
        foreach ($installments as $install) {
            $availableMonths = [];
            foreach ($install->avaibleMonth as $month) {
                $availableMonths[] = [
                    'month' => $month->month,
                    'description' => $month->description,
                ];
            }

            $data[] = [
                'id' => $install->id,
                'car' => $install->cars, 
                'brand' => $install->brand->brand,
                'price' => $install->price,
                'description' => $install->description,
                'available_month' => $availableMonths
            ];
        }

        return response()->json([
            'cars' => $data
        ]);
    }


    public function gettDetailInstallmentCars(Request $request, $id)
    {
        $installment = \App\Models\Installment::with(['brand', 'avaibleMonth'])->findOrFail($id);

        $availableMonths = [];
        foreach ($installment->avaibleMonth as $month) {
            $availableMonths[] = [
                'month' => $month->month,
                'description' => $month->description,
            ];
        }

        return response()->json([
            'instalment' => [
                'id' => $installment->id,
                'car' => $installment->cars,
                'brand' => $installment->brand->brand,
                'price' => $installment->price,
                'description' => $installment->description,
                'available_month' => $availableMonths
            ]
        ]);
    }

}
