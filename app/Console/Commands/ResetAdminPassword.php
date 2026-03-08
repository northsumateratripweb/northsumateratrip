<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'app:reset-admin-password {--password=admin123 : The new password to set}';
    protected $description = 'Reset password for first admin user';

    public function handle()
    {
        $user = User::first();
        if (!$user) {
            $this->error('No user found in database!');
            return 1;
        }

        $password = $this->option('password');
        $user->password = Hash::make($password);
        $user->save();

        $this->info("Password successfully reset!");
        $this->table(['Field', 'Value'], [
            ['ID', $user->id],
            ['Name', $user->name],
            ['Username', $user->username ?? 'N/A'],
            ['Email', $user->email],
            ['New Password', $password],
        ]);

        return 0;
    }
}
