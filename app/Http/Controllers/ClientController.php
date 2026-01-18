<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\File;
use App\Models\fileClient;
use App\Models\Legal_Session;
use Dom\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::get();
        return view('client.index', compact('client'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if (!$request->hasFile('fileId')) {
                throw new \Exception('لم يتم رفع أي صورة');
            }
            $file = $request->file('fileId');
            $fileName = $request->name . '_' . 'First' . uniqid() . '.' . $file->getClientOriginalExtension();
            $fileId = $file->storeAs('clients', $fileName, 'public');
            $client = Client::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'fileId' => $fileId,
            ]);
            DB::commit();
            return redirect()->route('client.index')
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
        $client = Client::find($id);
        return view('client.clientById', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $client = Client::find($id);
            $data = [
                'name'  => $request->name,
                'phone' => $request->phone,
            ];

            // في حال رفع ملف جديد
            if ($request->hasFile('fileId')) {

                // حذف الملف القديم (اختياري لكنه مهم)
                if ($client->fileId && Storage::disk('public')->exists($client->fileId)) {
                    Storage::disk('public')->delete($client->fileId);
                }

                $file = $request->file('fileId');
                $fileName = $request->name . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('clients', $fileName, 'public');

                $data['fileId'] = $filePath;
            }
            $client->update($data);
            DB::commit();
            return redirect()
                ->route('client.show', $client->id)
                ->with('success', 'تم تحديث بيانات الزبون بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating client', [
                'client_id' => $client->id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('حدث خطأ أثناء التحديث');
        }
    }

    public function destroy($id)
    {
        try {
            $client = Client::find($id);
            if ($client->fileId && Storage::disk('public')->exists($client->fileId)) {
                Storage::disk('public')->delete($client->fileId);
            }

            $client->delete();
            return redirect()->route('client.index')->with('success', 'تم حذف الموكل بنجاح');
        } catch (\Exception $e) {
            Log::error('Error deleting client: ' . $e->getMessage());
            return back()->withErrors('حدث خطأ أثناء الحذف');
        }
    }

    public function storeFile(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required|in:قضائي,محكمة',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // 2MB
        ]);
        DB::beginTransaction();
        try {
            $client = Client::findOrFail($id);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = $client->name . '_' . $validated['type'] . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('client_files', $fileName, 'public');
                $fileClient = fileClient::create([
                    'client_id' => $client->id,
                    'type' => $validated['type'],
                    'file' => $filePath,
                ]);
                DB::commit();
                return redirect()->back()
                    ->with('success', 'تم رفع الملف بنجاح');
            }
            return redirect()->back()
                ->with('error', 'لم يتم رفع أي ملف');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File upload error: ' . $e->getMessage(), [
                'client_id' => $id,
                'request' => $request->all()
            ]);
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء رفع الملف: ' . $e->getMessage());
        }
    }

    public function deleteFile($id)
    {
        DB::beginTransaction();
        try {
            $file = fileClient::find($id);
            if (Storage::disk('public')->exists($file->file)) {
                Storage::disk('public')->delete($file->file);
            }
            $file->delete();
            return redirect()->back()
                ->with('success', 'تم حذف الملف بنجاح');
            DB::commit();
            return redirect()->back()
                ->with('success', 'تم حذف الملف بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File delete error: ' . $e->getMessage(), [
                'file_id' => $id
            ]);
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف الملف.');
        }
    }


    
}
