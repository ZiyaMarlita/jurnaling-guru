<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Jurnal;

class JurnalPolicy
{
    public function update(User $user, Jurnal $jurnal)
    {
        return $user->role == 'guru'
            && $user->id == $jurnal->guru->user_id
            && $jurnal->status != 'dinilai';
    }

    public function delete(User $user, Jurnal $jurnal)
    {
        return $user->role == 'guru'
            && $user->id == $jurnal->guru->user_id
            && $jurnal->status != 'dinilai';
    }
}
