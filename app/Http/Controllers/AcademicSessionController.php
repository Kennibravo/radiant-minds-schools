<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AcademicSessionController extends Controller
{
    private function validateAcademicSession($request, $academicSession = null)
    {
        $messages = [
            'name.required' => 'This field is required',
            'name.unique' => 'Record exists'
        ];

        $validatedData = $request->validate([
            'name' => ['required', 'string', Rule::unique('academic_sessions')->ignore($academicSession)],
            'start_date' => ['required', 'date', Rule::unique('academic_sessions')->ignore($academicSession)],
            'end_date' => ['required', 'date', Rule::unique('academic_sessions')->ignore($academicSession), 'after:start_date']
        ], $messages);

        return $validatedData;
    }

    public function index()
    {
        $academicSessions = AcademicSession::all();
        return view('academicSession', compact('academicSessions'));
    }

    public function store(Request $request)
    {
        AcademicSession::create($this->validateAcademicSession($request));
        return back()->with('success', 'Academic Session Created!');
    }

    public function edit($id)
    {
        $academicSession = AcademicSession::findOrFail($id);
        return view('editAcademicSession', compact('academicSession'));
    }

    public function update($id, Request $request)
    {
       
        $academicSession = AcademicSession::findOrFail($id);
        $academicSession->update($this->validateAcademicSession($request, $academicSession));

        return redirect('/academicSessions')->with('success', 'Academic Session Updated!');
    }

    public function destroy($id, AcademicSession $academicSession)
    {
        $this->authorize('delete', $academicSession);
        $academicSession = AcademicSession::findOrFail($id);
        $results = $academicSession->results()->first();

        if (!is_null($results)) {
            return back()->with('error', 'Academic Session with results cannot be deleted!');
        }

        $academicSession->delete();
        return back()->with('success', 'Academic Session Deleted!');
    }

    public function setCurrentAcademicSession($id){
        $academicSession = AcademicSession::findOrFail($id);

        AcademicSession::where('current_session', 1)->update(['current_session' => null]);

        $academicSession->current_session = 1;
        $academicSession->save();

        return back()->with('success', $academicSession->name.' set as current session');
    }
}
