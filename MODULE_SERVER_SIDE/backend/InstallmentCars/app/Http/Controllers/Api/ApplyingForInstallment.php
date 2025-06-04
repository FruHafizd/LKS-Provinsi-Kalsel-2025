<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvaibleMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\InstallmentApplySocities;
use App\Models\Installment;
use App\Models\InstallmentApplyStatus;

class ApplyingForInstallment extends Controller
{
    public function createInstallment(Request $request)
    {
        $society = auth()->user(); // Ambil user yang login (society)

        if (!$society) {
            return response()->json([
                'message' => 'Unauthorized user'
            ], 401);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'instalment_id' => 'required|exists:installments,id',
            'months' => 'required|integer|min:1',
            'notes' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid field',
                'errors' => $validator->errors()
            ], 401);
        }

        // Cek validasi diterima oleh validator
        $validationAccepted = $society->validation()
            ->where('status', 'accepted')
            ->exists();

        if (!$validationAccepted) {
            return response()->json([
                'message' => 'Your data validator must be accepted by validator before'
            ], 401);
        }

        // Cek apakah sudah 2x mengajukan
        $existingApplications = InstallmentApplySocities::where('society_id', $society->id)->count();
        if ($existingApplications >= 2) {
            return response()->json([
                'message' => 'Application for a instalment can only be twice'
            ], 401);
        }

        // Cari available_month sesuai bulan yang diminta
        $availableMonth = AvaibleMonth::where('installment_id', $request->instalment_id)
            ->where('month', $request->months)
            ->first();
        if (!$availableMonth) {
            return response()->json([
                'message' => 'Requested months not available'
            ], 400);
        }

        // Simpan pengajuan cicilan
        $application = InstallmentApplySocities::create([
            'society_id' => $society->id,
            'installment_id' => $request->instalment_id,
            'available_month_id' => $availableMonth->id,
            'date' => now(),
            'notes' => $request->notes,
        ]);

        // Simpan status pengajuan, default status = 'pending'
        InstallmentApplyStatus::create([
            'society_id' => $society->id,
            'installment_id' => $request->instalment_id,
            'available_month_id' => $availableMonth->id,
            'installment_apply_societies_id' => $application->id,
            'status' => 'pending',
            'date' => now(),
        ]);


        return response()->json([
            'message' => 'Applying for Instalment successful'
        ], 200);
    }

public function getApplications(Request $request)
{
    $societyId = auth()->user()->id;

    $installments = Installment::with([
        'brand:id,brand',
        'avaibleMonth',
        'applications.statuses'
    ])->get();

    $result = $installments->map(function ($installment) use ($societyId) {
        return [
            'id' => $installment->id,
            'car' => $installment->cars,
            'brand' => $installment->brand->brand ?? '',
            'price' => $installment->price,
            'description' => $installment->description,
            'applications' => $installment->avaibleMonth->map(function ($month) use ($societyId) {
                // Cari pengajuan cicilan oleh society ini untuk bulan ini
                $applied = $month->installmentApplySocieties()
                    ->where('society_id', $societyId)
                    ->where('available_month_id', $month->id)
                    ->first();

                $status = 'pending';
                $notes = null;

                if ($applied) {
                    // Pastikan statuses sudah dimuat
                    $latestStatus = $applied->statuses ? $applied->statuses->sortByDesc('date')->first() : null;
                    $status = $latestStatus->status ?? 'pending';
                    $notes = $applied->notes;
                }

                return [
                    'month' => $month->month,
                    'nominal' => $month->nominal,
                    'apply_status' => $status,
                    'notes' => $notes,
                ];
            }),
        ];
    });

    return response()->json(['instalments' => $result]);
}



}
