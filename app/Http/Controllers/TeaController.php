<?php

namespace App\Http\Controllers;

use App\Models\Tea;
use Illuminate\Http\Request;




class TeaController extends Controller
{
    // Show all teas
    public function index()
    {


        $teas = Tea::all();
        return view('teas.index', compact('teas'));
    }

    // Show form to create a new tea
    public function create()
    {
        return view('teas.create');
    }

    // Store a new tea
    public function store(Request $request)
    {


        $request->validate([
            'tea_grade' => 'required|in:BOP,FBOP,PEKOE,DUST',
            'buy_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        Tea::create($request->all());


        return redirect()->route('teas.index')->with('success', 'Tea record added successfully!');
    }

    // Show form to edit an existing tea
    public function edit(Tea $tea)
    {
        return view('teas.edit', compact('tea'));
    }

    // Update an existing tea
    public function update(Request $request, Tea $tea)
    {
        $request->validate([
            'tea_grade' => 'required|in:BOP,FBOP,PEKOE,DUST',
              'buy_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $tea->update($request->all());

        return redirect()->route('teas.index')->with('success', 'Tea record updated successfully!');
    }

    // Delete a tea
public function destroy($id)
{
    $tea = Tea::findOrFail($id);

    // Instead of deleting, update the status to 0
    $tea->status = 0;
    $tea->save();

    return redirect()->back()->with('success', 'Tea marked as inactive successfully.');
}




}
