<?php

namespace App\Http\Controllers;

use App\Http\Requests\LawyerRequest;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LawyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lawyers = Lawyer::get();
        return view('lawyer.index', compact('lawyers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return "ddsda";
        return view('lawyer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'userName' => $request->fullName,
                'email' => $request->email,
                'password' => Hash::make('12341234'),
            ]);
            $user->save();
            $lawyer = Lawyer::create([
                'user_id' => $user->id,
                'fullName' => $request->fullName,
                'seconedName' => $request->seconedName,
                'motherName' => $request->motherName,
                'phone' => $request->phone,
                'birthDate' => $request->birthDate,
                'secretariat' => $request->secretariat,
                'nationalNumer' => $request->nationalNumer,
                'status' => $request->status,
                'joinDate' => $request->joinDate,
            ]);
            $user->assignRole('lawyer');
            DB::commit();
            return redirect()->route('lawyer.index')
                ->with('success', 'تم إضافة المحامي والمستخدم بنجاح!');
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
        $lawyer = Lawyer::find($id);
        return view('lawyer.edit', compact('lawyer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        try {
            $lawyer = Lawyer::find($id)->first();
            $lawyer->fullName = $request->fullName;
            $lawyer->seconedName = $request->seconedName;
            $lawyer->motherName = $request->motherName;
            $lawyer->phone = $request->phone;
            $lawyer->birthDate = $request->birthDate;
            $lawyer->secretariat = $request->secretariat;
            $lawyer->nationalNumer = $request->nationalNumer;
            $lawyer->status = $request->status;
            $lawyer->joinDate = $request->joinDate;
            $lawyer->save();
            return redirect()->route('lawyer.index')
                ->with('success', 'تم تعديل بيانات المحامي بنجاح المحامي والمستخدم بنجاح!');
        } catch (\Throwable $ex) {
            return redirect()->back()->with(['error' => 'فشل في التحديث: ' . $ex->getMessage()])->withInput();
        }
    }

    public function block($id)
    {
        $lawyer = Lawyer::find($id);
        $block =$lawyer->user->block ;
        if ($block == 0) {
            $block= 1;
        } else {
            $block = 0;
        }
        $lawyer->user->save();
        return redirect()->back();
    }

}
