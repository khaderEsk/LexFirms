<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StageController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        $stages = Stage::with('lawyers')
            ->whereDate('date', $date)
            ->get();
        return view('stage.index', compact(['stages', 'date']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'legal_case_id' => 'required|exists:legal_cases,id',
            'subject'       => 'required|string',
            'date'          => 'nullable|date',
            'note'          => 'nullable|string',
            'lawyer_ids'    => 'required|array|min:1',
            'lawyer_ids.*'  => 'exists:lawyers,id',
        ]);
        DB::beginTransaction();
        try {
            $stage = Stage::create([
                'legal_case_id' => $validated['legal_case_id'],
                'subject'       => $validated['subject'],
                'note'          => $validated['note'] ?? null,
                'date'          => $validated['date'] ?? null,
            ]);

            $lawyerIds = $validated['lawyer_ids'];

            // إضافة المحامي الحالي تلقائيًا إن لم يكن مختارًا
            // if (!in_array(auth()->id(), $lawyerIds)) {
            //     $lawyerIds[] = auth()->id();
            // }

            $stage->lawyers()->sync($lawyerIds);

            DB::commit();
            return redirect()->back()->with('success', 'تم إضافة المرحلة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Stage store error', [
                'error'   => $e->getMessage(),
                'case_id' => $request->legal_case_id,
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المرحلة');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $vald = $request->validate([
            'subject' => 'required|string',
            'date'    => 'nullable|date',
            'note'    => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $stage = Stage::find($id);

            // ضع القيم الجديدة مؤقتًا
            $stage->fill($vald);

            $data = [];

            if ($stage->isDirty('subject')) {
                $data['before_update_subject'] = $stage->getOriginal('subject');
            }

            if ($stage->isDirty('date')) {
                $data['before_update_date'] = $stage->getOriginal('date');
            }

            if ($stage->isDirty('note')) {
                $data['before_update_note'] = $stage->getOriginal('note');
            }
            // return $data['before_update_note'];
            // دمج القيم الجديدة مع القديمة
            if (!empty($data)) {
                $stage->update(array_merge($data, $stage->getDirty()));
            }

            DB::commit();

            return redirect()->back()->with('success', 'تم التحديث بنجاح');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Stage update error', [
                'error' => $e->getMessage(),
                'stage_id' => $id,
            ]);

            return redirect()->back()->with('error', 'حدث خطأ أثناء التحديث');
        }
    }

    public function destroy($id)
    {
        //
    }
}
