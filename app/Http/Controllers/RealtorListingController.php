<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ListingRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RealtorListingController extends BaseController
{
    use AuthorizesRequests;
    public function __construct()
     {
         $this->authorizeResource(Listing::class, 'listing');
     }
     
    public function index(Request $request) { 
        $filters = ['deleted' => $request->boolean('deleted'),...$request->only(['by','order'])];
        $listings = Auth::user()->listings() ->filter($filters)->paginate(5)->withQueryString();
       
        return inertia('Realtor/Index',
        ['filters' => $filters, 'listings' => $listings] );
    }
    public function create()
    {
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request)
    {
        $data = $request->validated();
        $request->user()->listings()->create($data); //Get info current user authenticated

        return redirect()->route('realtor.listings.index')
                        ->with('success','Listing was created!');
    }
    public function edit(Listing $listing)
    {
        return inertia('Realtor/Edit',['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, Listing $listing)
    {
        $data = $request->validated();
        $listing->update($data);


        return redirect()->route('realtor.listings.index')
        ->with('success', 'Listing was changed!');
    }
    public function destroy(Listing $listing){
        $listing->deleteOrFail();
        return redirect()->back()
        ->with('success', 'Listing was deleted!');
    }
    
}