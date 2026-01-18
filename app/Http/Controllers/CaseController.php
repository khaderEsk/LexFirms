<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaseRequest;
use App\Models\LegalCase;
use App\Models\Client;
use App\Models\File;
use App\Models\Lawyer;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CaseController extends Controller
{
    public function index()
    {
        $cases = LegalCase::get();
        return view('cases.index', compact('cases'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('cases.create', compact('clients'));
    }

    public function store(CaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $yearFull = $request->case_year;
            $year = substr($yearFull, -2);
            $caseType = $request->case_type;
            $lastCase = LegalCase::where('case_type', $caseType)
                ->where('name_case', 'like', $caseType . $year . '%')
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();
            $number = 0;
            if ($lastCase) {
                $lastNumber = intval(substr($lastCase->nameCase, -3));
                $number = $lastNumber + 1;
            }
            $formattedNumber = str_pad($number, 3, '0', STR_PAD_LEFT);
            $requestData = $request->validated();
            $requestData['name_case'] = $caseType . $year . $formattedNumber;
            LegalCase::create($requestData);
            DB::commit();
            return redirect()->route('case.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File upload error', [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'حدث خطأ أثناء رفع الملف');
        }
    }



    public function show($id)
    {
        $case = LegalCase::with(['stages' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        $lawyers = Lawyer::all();
        // $currentLawyerId = auth()->user()->lawyer->id;
        return view('cases.caseById', compact(['case', 'lawyers']));
    }

    public function edit($id)
    {
        $case = LegalCase::find($id);
        return view('cases.edit', compact('case'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $case = LegalCase::find($id);
            $data = [
                'subject'  => $request->subject,
                'court' => $request->court,
                'department' => $request->department,
                'base_number' => $request->base_number,
            ];
            $case->update($data);
            DB::commit();
            return redirect()
                ->route('cases.show', $case->id)
                ->with('success', 'تم تحديث بيانات الزبون بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating client', [
                'client_id' => $case->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('حدث خطأ أثناء التحديث');
        }
    }


    public function updateCase(Request $request, $id)
    {

        $request->validate([
            'dollar_price'  => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
        ]);
        DB::beginTransaction();
        try {

            $case = LegalCase::findOrFail($id);
            $syrianPrice = $request->exchange_rate * $request->dollar_price;
            $case->update([
                'dollar_price'  => $case->dollar_price + $request->dollar_price,
                'exchange_rate' => $request->exchange_rate,
                'syrian_prices' => $syrianPrice,
                'remaining_balance_of_expenditure' => $syrianPrice,
            ]);
            DB::commit();
            return redirect()
                ->route('cases.show', $case->id)
                ->with('success', 'تم تحديث بيانات الزبون بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating client', [
                'client_id' => $case->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('حدث خطأ أثناء التحديث');
        }
    }

    public function destroy(string $id)
    {
        //
    }

    public function fileStore(Request $request)
    {
        $validated = $request->validate([
            'legal_case_id' => 'required|exists:legal_cases,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);
        DB::beginTransaction();
        try {
            $file = $request->file('file');
            $lawyer = auth()->user()->lawyer->id;
            $originalName = $file->getClientOriginalName();
            $fileName = $request->legal_case_id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('client_files', $fileName, 'public');
            File::create([
                'legal_case_id' => $request->legal_case_id,
                'original_name' => $originalName,
                'path' => $filePath,
                'lawyer_id' => $lawyer
            ]);
            $satge = Stage::create([
                'legal_case_id' => $request->legal_case_id,
                'subject' => ' : إضافة ملف' . $fileName,
            ]);

            $satge->lawyers()->sync($lawyer);
            DB::commit();
            return redirect()->back()->with('success', 'تم رفع الملف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File upload error', [
                'error' => $e->getMessage(),
                'case_id' => $request->legal_case_id
            ]);
            return redirect()->back()->with('error', 'حدث خطأ أثناء رفع الملف');
        }
    }


    public function exportPdf(LegalCase $case)
    {
        $case->load('stages', 'client');
        $pdf = Pdf::loadView('pdf.case', [
            'case' => $case
        ])->setPaper('A4', 'rtl');
        return $pdf->download('case_' . $case->id . '.pdf');
    }

    public function getFille($id)
    {
        $case = LegalCase::with('files')->find($id);
        return view('partials.files', compact('case'));
    }

    public function getStage($id)
    {
        $case = LegalCase::with('stages')->find($id);
        $case->stages = $case->stages->sortByDesc('created_at');
        return view('partials.stages', compact('case'));
    }
}
