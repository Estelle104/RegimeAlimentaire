<?php 

namespace App\Models;

use CodeIgniter\Model;

class AdminController extends Model
{
    protected $table = 'adminusers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password'];

    public function verifyAdmin($username, $password)
    {
        $username = trim((string) $username);
        $password = trim((string) $password);
        $admin = $this->where('username', $username)->first();
        if ($admin && $password === $admin['password']) {
            return true;
        }
        return false;
    }
}