<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::all();
        return response(200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:classrooms']
        ]);

        Classroom::create($request->all());
        return response(200);
    }

    public function edit($id)
    {

        $classroom = Classroom::findOrFail($id);
        return response(200);
    }

    public function update($id, Request $request)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());
        return response(200);
    }

    public function destroy($id, Classroom $classroom)
    {
        $this->authorize('delete', $classroom);
        $classroom = Classroom::findOrFail($id);
        $classroom->delete();
        return response(200);
    }

    public function editSubjects($id)
    {
        $classroom = Classroom::findOrFail($id);

        $subjects = $classroom->subjects()->all();
    }

    public function updateSubjects($id, Request $request)
    {
        $classroom = Classroom::findOrFail($id);

        $this->validate($request, [
            'subjects' => ['required']
        ]);

        $subjects = $request->subjects;

        foreach ($subjects as $subject){
            
            $checkUniqueness = $classroom->subjects()->where('name', $subject)->first();
            
            if(!is_null($checkUniqueness)){
                throw ValidationException::withMessages(['subjects' => $subject . ' is already registered']);
            }

            $subjectID = Subject::where('name', $subject)->first()->id;

            $classroom->subjects()->attach($subjectID);
        }
    }
}
