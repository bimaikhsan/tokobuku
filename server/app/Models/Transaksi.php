<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Transaksi extends Model
{
    /**
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * @var array
     */
    protected $fillable = [
        'id_user','buku', 'metode',
    ];
}
?>