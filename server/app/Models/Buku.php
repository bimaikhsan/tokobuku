<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Buku extends Model
{
    /**
     * @var string
     */
    protected $table = 'buku';

    /**
     * @var array
     */
    protected $fillable = [
        'judul', 'harga', 'deskripsi', 'jumlah','gambar',
    ];
}
?>