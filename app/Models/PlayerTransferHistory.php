<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerTransferHistory extends Model
{
    use HasFactory;

    // Opsional, tapi disarankan untuk memastikan Eloquent membaca tabel yang tepat
    protected $table = 'player_transfer_histories';

    // Kolom-kolom yang diizinkan untuk diisi massal (mass assignment)
    protected $fillable = [
        'user_id',
        'from_team',
        'to_team',
        'transfer_type',
        'notes',
        'recorded_by',
    ];

    /**
     * Relasi ke pemain (User) yang ditransfer
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke admin/staff yang mencatat riwayat transfer ini
     */
    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
