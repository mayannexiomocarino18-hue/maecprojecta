<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;

class DegreeController extends Controller
{
    //
    public function index()
    {
        $degrees = Degree::all();
        return view('degrees.index', compact('degrees'));
    }

    public function create()
    {
        return view('degrees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:degrees,title',
        ]);

        $degree = Degree::create($request->all());

        if ($request->ajax()) {
            $request->session()->flash('message', 'Degree added successfully.');
            return response()->json($degree);
        }

        return redirect()
            ->route($this->indexRoute())
            ->with('message', 'Degree added successfully.');
    }

    public function show($id)
    {
        $degree = Degree::withCount('students')->findOrFail($id);
        return view('degrees.show', compact('degree'));
    }

    public function edit($id)
    {
        $degree = Degree::findOrFail($id);
        return view('degrees.edit', compact('degree'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:degrees,title,' . $id,
        ]);

        $degree = Degree::findOrFail($id);
        $degree->update($request->all());

        if ($request->ajax()) {
            return response()->json($degree->fresh());
        }

        return redirect()->route($this->indexRoute());
    }

    public function destroy(Request $request, $id)
    {
        $degree = Degree::findOrFail($id);

        if ($degree->students()->count() > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Cannot delete: Degree is in use.',
                ], 422);
            }

            return redirect()->back()->with('error', 'Cannot delete: Degree is in use.');
        }

        $degreeData = $degree->toArray();
        $degree->delete();

        if ($request->ajax()) {
            return response()->json($degreeData);
        }

        return redirect()->route($this->indexRoute());
    }

    protected function indexRoute(): string
    {
        return session('user_role') === 'admin'
            ? 'admin.degrees.index'
            : 'degrees.index';
    }
}
