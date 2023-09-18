<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //show all listings
    public function index()
    {
        return view('listings.index', [ 'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6) ]);
   }

    //show single listing
    public function show(Listing $listing) {

        return view('listings.show', [
            'listing' => $listing
        ]);
    }
    //Show create form
    public function create() {
        return view('listings.create');
    }

    //Store listing data
    public function store(Request $request) {

        $formField= $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'tags' => 'required',
            'description' => 'required',
        ]);
        If($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formField['user_id'] = auth()->user()->id;

        Listing::create($formField);

        return redirect('/')->with('message', 'Listing created successfully.');

    }

    //Show edit form

    public function edit(Listing $listing) {
        return view('listings.edit', [
            'listing' => $listing
        ]);
    }

    //Edit submit to update
    public function update(Request $request, Listing $listing) {


        //make sure logged in user is owner

        if($listing->user_id !=auth()->id()){
            abort(403, 'Unauthorized action.');
        }
        $formField= $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => 'required|email',
            'tags' => 'required',
            'description' => 'required',
        ]);
        If($request->hasFile('logo')) {
            $formField['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formField);

        return back()->with('message', 'Listing update successfully.');

    }

    public function destroy(Listing $listing) {
        if($listing->user_id !=auth()->id()){
            abort(403, 'Unauthorized action.');
        }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully.');
    }

    public function manage() {
        return view('listings.manage', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }
}
