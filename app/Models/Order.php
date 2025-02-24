<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'pro_id',
        'userid',
        'buyer_name',
        'buyer_email',
        'buyer_phone_number',
        'buyer_country_of_origin',
        'passport',
        'license',
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
        'pickup_car_date',
        'deliver_car_date',
        'payment_status',
        'amount'
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'driver_age' => 'integer',
        'payment_status' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'pro_id');
    }
}