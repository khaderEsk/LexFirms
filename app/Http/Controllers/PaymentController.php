<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Lawyer;
use App\Models\LegalCase;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month;
        $year  = $request->year;

        $payments = Payment::query();

        if ($month) {
            $payments->whereMonth('created_at', $month);
        }

        if ($year) {
            $payments->whereYear('created_at', $year);
        }

        $payments = $payments->get(); // ← مهم جدًا

        $total = $payments->sum('amount');
        $cases = LegalCase::all();
        return view('payment.index', compact(
            'payments',
            'total',
            'month',
            'year',
            'cases'
        ));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $fileId = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = 'payment_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $fileId = $file->storeAs('Payment', $fileName, 'public');
            }
            $payment = Payment::create([
                'legal_case_id' => $request->legal_case_id,
                'amount' => $request->amount,
                'notes' => $request->note,
                'currency' => '$',
                'img' =>  $fileId
            ]);
            $case = LegalCase::find($request->legal_case_id);
            $case->update([
                'remaining_balance_of_payment' => $case->remaining_balance_of_payment - $request->amount
            ]);
            DB::commit();
            return redirect()->back()
                ->with('success', 'تم إضافة الموكل والمستخدم بنجاح!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating lawyer: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
