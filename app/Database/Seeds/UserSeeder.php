<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data=array(
            'name'=>'admin',
            'username'=>'admin',
            'email'=>'admid@localhost.com',
            'password'=>password_hash('123456',PASSWORD_BCRYPT)
        );
        $this->db->table('users')->insert($data);

    }
}
