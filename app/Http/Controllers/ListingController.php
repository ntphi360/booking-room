<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ListingRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ListingController extends BaseController
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function __construct(){
        $this->authorizeResource(Listing::class,'listing');
    }
    
    public function index(Request $request)
    {
        return inertia(
            'Listings/Index',
            [
                'filters' => $request->only([
                    'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
                ]),
                'listings' => Listing::orderByDesc('created_at')
                    ->paginate(12 )
                    ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create',Listing::class);
        return inertia('Listings/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ListingRequest $request)
    {
        $data = $request->validated();
        $request->user()->listings()->create($data); //Get info current user authenticated

        return redirect()->route('listings.index')
                        ->with('success','Listing was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return inertia('Listings/Show',['listing' => $listing]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia('Listings/Edit',['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ListingRequest $request, Listing $listing)
    {
        $data = $request->validated();
        $listing->update($data);


        return redirect()->route('listings.index')
        ->with('success', 'Listing was changed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();
 
        return redirect()->back()
            ->with('success', 'Listing was deleted!');
    }
}