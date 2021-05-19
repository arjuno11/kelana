<?php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $park = \App\Models\Park::all();
        return view('park.index', compact('park'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(([
            'park_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]));

        // $imgName = time() . '.' . request()->image->getClientOriginalExtension();

        $image = $request->file('park_img');
        $destinationPath = public_path('/images');
        $imgName = time() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $imgName);

        // $request->story_img->move(public_path('images'), $imgName);

        Park::create([
            'park_title' => $request->park_title,
            'park_date' => $request->park_date,
            'park_description' => $request->park_description,
            'park_img' => $imgName,
        ]);

        return redirect('park');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Park  $park
     * @return \Illuminate\Http\Response
     */
    public function show(Park $park)
    {
        return view('park.show', compact('park'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Park  $park
     * @return \Illuminate\Http\Response
     */
    public function edit(Park $park)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Park  $park
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Park $park)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Park  $park
     * @return \Illuminate\Http\Response
     */
    public function destroy(Park $park)
    {
        //
    }

    public function search(Request $request)
    {
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $park = Park::query()
            ->where('park_title', 'LIKE', "%{$search}%")
            ->get();

        // Return the search view with the resluts compacted
        return view('park.index', compact('park'));
    }
}
