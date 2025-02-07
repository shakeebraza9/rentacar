<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'car_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone_number',
        'buyer_country_of_origin',
        'buyer_sec_name',
        'buyer_sec_phone_number',
        'buyer_sec_invoice_address',
        'driver_name',
        'driver_id_passport_number',
        'driver_license_number',
        'driver_age',
        'driver_mobile_number',
        'flight_no',
        'note',
        'from_date',
        'to_date',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];


    public function Findproduct()
    {
        return $this->belongsTo(product::class);
    }

    /**
     * Check if the car is available for the given date range.
     *
     * @param int $carId
     * @param string $fromDate
     * @param string $toDate
     * @return bool
     */
    public static function isCarAvailable($carId, $fromDate, $toDate)
    {
        return !self::where('pro_id', $carId)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->where('from_date', '<=', $toDate)
                      ->where('to_date', '>=', $fromDate);
            })
            ->where('status', 'confirmed')
            ->exists();
    }
}
