<?php

namespace App\Policies;

use App\Models\Employee;

class EmployeePolicy
{
    public function viewAny(Employee $user): bool
    {
        return $user->hasRole(['super admin', 'admin']);
    }

    public function view(Employee $user, Employee $model): bool
    {
        if ($user->hasRole('super admin')) {
            return true;
        }

        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $model->id;
    }

    public function create(Employee $user): bool
    {
        return $user->hasRole(['super admin', 'admin']);
    }

    public function update(Employee $user, Employee $model): bool
    {
        // Super admin bisa edit siapa saja
        if ($user->hasRole('super admin')) {
            return true;
        }

        // Admin tidak boleh edit super admin
        if ($user->hasRole('admin')) {
            return ! $model->hasRole('super admin');
        }

        // Staff hanya bisa edit dirinya sendiri
        return $user->id === $model->id;
    }

    public function delete(Employee $user, Employee $model): bool
{
    // Cek apakah model adalah super admin
    if ($model->hasRole('super admin')) {

        // Hitung jumlah super admin
        $superAdminCount = Employee::role('super admin')->count();

        // Jika cuma 1 super admin → tidak boleh dihapus
        if ($superAdminCount <= 1) {
            return false;
        }
    }

    // Super admin bisa hapus siapa saja (selain kasus di atas)
    if ($user->hasRole('super admin')) {
        return true;
    }

    // Admin tidak boleh hapus super admin
    if ($user->hasRole('admin')) {
        return ! $model->hasRole('super admin');
    }

    // Staff hanya bisa hapus dirinya sendiri
    return $user->id === $model->id;
}


}