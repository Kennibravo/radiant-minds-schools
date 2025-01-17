<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    private function teacherValidation($request, $teacher = null)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', Rule::unique('teachers')->ignore($teacher), 'email:rfc,dns'],
            'phone' => ['required', 'string', Rule::unique('teachers')->ignore($teacher), 'max:15', 'min:10'],
            'date_of_birth' => ['required', 'date', 'before:' . now()]
        ]);

        return $validatedData;
    }

    private function generateFullNameSlug($firstName, $lastName)
    {
        $fullname = $firstName . ' ' . $lastName . ' ' . Str::random(5);
        $slug = Str::of($fullname)->slug('-');

        return $slug;
    }

    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers', compact('teachers'));
    }

    public function create()
    {
        $this->authorize('create', Teacher::class);
        return view('createTeacher');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Teacher::class);

        $validatedData = $this->teacherValidation($request);

        $slug = $this->generateFullNameSlug($validatedData['first_name'], $validatedData['last_name']);

        $data = array_merge($validatedData, ['slug' => $slug, 'status' => 'active']);

        Teacher::create($data);

        return redirect()->route('teacher.index')->with('success', 'Teacher Created');
    }

    public function show(Teacher $teacher)
    {
        return view('showTeacher', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        return view('editTeacher', compact('teacher'));
    }

    public function update(Teacher $teacher, Request $request)
    {
        $this->authorize('update', $teacher);

        $validatedData = $this->teacherValidation($request, $teacher);

        //check if either the first or last name has changed to generate a new slug
        if ($teacher->first_name != $validatedData['first_name'] || $teacher->last_name != $validatedData['last_name']) {
            $slug = $this->generateFullNameSlug($validatedData['first_name'], $validatedData['last_name']);
            $data = array_merge($validatedData, ['slug' => $slug]);
        } else {
            $data = $validatedData;
        }

        $teacher->update($data);

        return redirect()->route('teacher.edit', ['teacher' => $teacher])->with('success', 'Teacher Updated!');
    }

    public function suspend(Teacher $teacher)
    {
        $this->authorize('suspend', $teacher);

        $teacher->status = 'suspended';

        $teacher->save();

        return redirect()->back()->with('success', 'Teacher Suspended!');
    }

    public function activate(Teacher $teacher)
    {
        $this->authorize('activate', $teacher);

        $teacher->status = 'active';

        $teacher->save();

        return redirect()->back()->with('success', 'Teacher Activated!');
    }

    public function deactivate(Teacher $teacher)
    {
        $this->authorize('deactivate', $teacher);

        $teacher->status = 'inactive';

        $teacher->save();

        return redirect()->back()->with('success', 'Teacher Deactivated!');
    }

    public function destroy(Teacher $teacher)
    {
        $this->authorize('delete', $teacher);

        $teacher->delete();

        return redirect()->back()->with('success', 'Teacher Deleted!');
    }

    // public function forceDelete($id, Teacher $teacher)
    // {
    //     $this->authorize('forceDelete', $teacher);

    //     $teacher = Teacher::findOrFail($id);

    //     $teacher->forceDelete();
    //     return response(200);
    // }

    // public function restore($id, Teacher $teacher)
    // {
    //     $this->authorize('restore', $teacher);

    //     $teacher = Teacher::onlyTrashed()->findOrFail($id);

    //     $teacher->restore();

    //     return response(200);
    // }
}
