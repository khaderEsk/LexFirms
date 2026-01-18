<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Report;
use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            Report::create([
                'legal_case_id' => $request->legal_case_id,
                'description' => $request->description
            ]);
            $case = LegalCase::find($request->legal_case_id);
            $case->progress += $request->progress;
            $case->save();
            DB::commit();
            return redirect()->back()
                ->with('success', 'تم إضافة التقرير بنجاح!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating lawyer: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'حدث خطأ أثناء الحفظ: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reports = LegalCase::with('reports')->findOrFail($id);
        // return $reports;
        return view('partials.progress', compact('reports'));
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
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
