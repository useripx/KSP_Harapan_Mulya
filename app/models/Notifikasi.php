<?php
/**
 * Notifikasi Model
 */

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    public function getUnsent()
    {
        return $this->where('status', 'QUEUE')->get();
    }

    public function markAsSent($id)
    {
        return $this->update($id, ['status' => 'SENT']);
    }

    public function markAsFailed($id, $error)
    {
        return $this->update($id, [
            'status' => 'FAILED',
            'last_error' => $error
        ]);
    }
}
