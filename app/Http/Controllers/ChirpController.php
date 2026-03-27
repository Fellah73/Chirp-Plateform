<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    public function index()
    {

        $chirps = Chirp::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('home', ['chirps' => $chirps]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|max:255|min:5',
        ], [
            'message.required' => 'Please write something.',
            'message.max' => '255 characters at most.',
            'message.min' => '5 characters at least.',
        ]);

        Chirp::create([
            'message' => $request->message,
        ]);

        return redirect('/')->with('success', 'Congratulations! Your chirp has been posted.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Chirp $chirp)
    {
        return view('chirps.edit', compact('chirp'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'message' => 'required|max:255|min:5',
        ], [
            'message.required' => 'Please write something.',
            'message.max' => '255 characters at most.',
            'message.min' => '5 characters at least.',
        ]);

        $chirp = Chirp::findOrFail($id);
        $chirp->update($validatedData);

        return redirect('/')->with('success', 'Congratulations! Your chirp has been updated.');
    }

    public function destroy(Chirp $chirp)
    {
        //  $this->authorize('delete', $chirp);
        $chirp->delete();

        return redirect('/')->with('success', 'Congratulations! Your chirp has been deleted.');
    }
}
