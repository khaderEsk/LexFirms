<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Lawyer;
use App\Models\LegalCase;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function index(Request $request)
    {
        $limitMonths = 6;

        // آخر 6 أشهر
        $months = collect();
        for ($i = 0; $i < $limitMonths; $i++) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        // الشهر المختار
        $selectedMonth = $request->get('month', now()->format('Y-m'));

        if (!$months->contains($selectedMonth)) {
            $selectedMonth = now()->format('Y-m');
        }

        $date = Carbon::createFromFormat('Y-m', $selectedMonth);

        // 🟢 جلب مصاريف المحامي الحالي فقط
        $expenses = Expense::where('lawyer_id', auth()->user()->lawyer->id)
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->orderBy('date', 'desc')
            ->get();

        // 🟢 مجموع حسب العملة
        $totalSYP = $expenses->sum('amount');

        return view('expense.index', [
            'expenses'      => $expenses,
            'months'        => $months,
            'selectedMonth' => $selectedMonth,
            'totalSYP'      => $totalSYP,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function all(Request $request)
    {
        $lawyerId = $request->get('lawyer_id', null);
        $month    = $request->get('month', now()->format('m')); // YYYY-MM
        $year     = $request->get('year', now()->format('Y'));  // YYYY
        $query = Expense::query()->with('lawyer');
        if ($lawyerId) {
            $query->where('lawyer_id', $lawyerId);
        }

        if ($month && $year) {
            $query->whereYear('date', $year)
                ->whereMonth('date', $month);
        } elseif ($year) {
            $query->whereYear('date', $year);
        } elseif ($month) {
            $query->whereMonth('date', $month);
        }
        $expenses = $query->orderBy('date', 'desc')->get();
        $total = $expenses->sum('amount');

        $lawyers = Lawyer::get();
        $totalUSD = $expenses->where('currency', 'USD')->sum('amount');
        $totalSYP = $expenses->where('currency', 'SYP')->sum('amount');
        $cases = LegalCase::all();
        return view('expense.all', compact('expenses', 'lawyers', 'total', 'lawyerId', 'month', 'year', 'totalUSD', 'totalSYP', 'cases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description'       => 'required|string',
            'amount'          => 'numeric',
        ]);
        DB::beginTransaction();
        try {
            $expense = Expense::create([
                'lawyer_id' => $request->lawyer_id ?? auth()->user()->lawyer->id,
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'date' => now(),
                'legal_case_id' => $request->legal_case_id
            ]);
            $case = LegalCase::find($request->legal_case_id);
            $case->remaining_balance_of_expenditure = $case->remaining_balance_of_expenditure - $request->amount;
            $case->save();
            DB::commit();
            return redirect()->back()->with('success', 'تم إضافة الصرفية بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Stage store error', [
                'error'   => $e->getMessage(),
                'case_id' => $request->legal_case_id,
            ]);
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المرحلة');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expenses = Expense::with('lawyer')
            ->where('legal_case_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $case = LegalCase::find($id);
        return view('expense.caseId', compact(['expenses', 'case']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function expensesPdf($id)
    {
        $reports = Expense::orderBy('created_at', 'desc')->get();

        // بيانات إضافية للتقرير
        $data = [
            'title' => 'تقرير البيانات',
            'date' => date('Y-m-d'),
            'reports' => $reports,
            'total' => $reports->sum('value')
        ];

        // إنشاء PDF مع الخط العربي
        $pdf = PDF::loadView('expense.expenses-pdf', $data);

        // إعدادات الخط العربي
        $pdf->getDomPDF()->set_option('defaultFont', 'DejaVu Sans');

        // إعدادات أخرى
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        // تحميل الملف
        return $pdf->download('تقرير_البيانات_' . date('Y-m-d') . '.pdf');
    }
}
