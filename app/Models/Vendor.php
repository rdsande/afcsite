<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'phone_number',
        'region',
        'district',
        'ward',
        'street',
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    /**
     * Scope to get only active vendors.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope to get vendors by district.
     */
    public function scopeByDistrict($query, $district)
    {
        return $query->where('district', $district);
    }
    
    /**
     * Scope to get vendors by region.
     */
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }
    
    /**
     * Get the full address of the vendor.
     */
    public function getFullAddressAttribute()
    {
        $address = [];
        
        if ($this->street) {
            $address[] = $this->street;
        }
        if ($this->ward) {
            $address[] = $this->ward;
        }
        if ($this->district) {
            $address[] = $this->district;
        }
        if ($this->region) {
            $address[] = $this->region;
        }
        
        return implode(', ', $address);
    }
}