<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
class UserImportServices {

    public function import($filepath){

    // dd($filepath);
    if(!file_exists($filepath)){
        throw new \Exception('File not found');
    }

        $handle = fopen($filepath,'r');
        $header = fgetcsv($handle);

        while(($row = fgetcsv($handle)) !== false){
            
            [$user_id , $username, $email , $password] = $row;

        if(!$this->isValidUsername($username)){
            Log::warning("Invalid Username: {$username}");
            continue;
        }

        if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            Log::warning("Invalid Email: {$email}");
            continue;
        }

        try{

        
        $user = User::create([
            'username'=> $username,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        
        // dd($user);

        } catch(\Exception $e) {
            Log::error("Database error for {$email}: " . $e->getMessage());
        }
    }

        fclose($handle);
    }

    public function isValidUsername($username){

        return preg_match('/^[a-zA-Z0-9]{3,20}$/', $username);
    }
}


