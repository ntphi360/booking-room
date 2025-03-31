<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\ListingFactory> */
    use HasFactory;
    protected $fillable = ['beds','baths','area','city','street','street_nr','code','price'];  
    
    // RELATION
    public function owner(){
        return $this->belongsTo(User::class, 'by_user_id');
    }

    //LOCAL SCOPE 
    public function scopeMostRecent(Builder $query){
        return $query->orderByDesc('created_at');
    }
    
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            isset($filters['priceFrom']),
            fn ($query) => $query->where('price', '>=', $filters['priceFrom'])
        )->when(
            isset($filters['priceTo']),
            fn ($query) => $query->where('price', '<=', $filters['priceTo'])
        )->when(
            isset($filters['beds']),
            fn ($query) => $query->where('beds', (int)$filters['beds'] < 6 ? '=' : '>=', $filters['beds'])
        )->when(
            isset($filters['baths']),
            fn ($query) => $query->where('baths', (int)$filters['baths'] < 6 ? '=' : '>=', $filters['baths'])
        )->when(
            isset($filters['areaFrom']),
            fn ($query) => $query->where('area', '>=', $filters['areaFrom'])
        )->when(
            isset($filters['areaTo']),
            fn ($query) => $query->where('area', '<=', $filters['areaTo'])
        );
    }
    

}