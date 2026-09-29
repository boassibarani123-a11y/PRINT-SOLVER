<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code','customer_name','customer_phone','customer_email','customer_address',
        'service_type','file_name','file_path','pages','copies',
        'price_per_page','total_price','notes','status',
    ];

    protected $casts = [
        'pages' => 'integer',
        'copies' => 'integer',
        'price_per_page' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function serviceLabel(): string
    {
        return match ($this->service_type) {
            'color'   => 'Print Berwarna',
            'bw'      => 'Print Hitam Putih',
            'booklet' => 'Booklet',
            default   => ucfirst($this->service_type),
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'pending'    => 'bg-yellow-500/20 text-yellow-300 border-yellow-500/40',
            'proses'     => 'bg-cyan-500/20 text-cyan-300 border-cyan-500/40',
            'selesai'    => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
            'dibatalkan' => 'bg-rose-500/20 text-rose-300 border-rose-500/40',
            default      => 'bg-gray-500/20 text-gray-300 border-gray-500/40',
        };
    }
}
