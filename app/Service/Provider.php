<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\User;

abstract class Provider { 

    /**
     * File Path
     */
    protected $path;

    /**
     * User object lines will be used in complex read 
     */
    protected $size;

    /**
     * number of lines to skip when read
     * json file in complex read
     */
    protected $skip;

    /**
     * Provider name
     */
    protected $name;

    /**
     * Read json file content
     * @return array
     */
    public function read()
    {
        $file = storage_path('json/'.$this->path);
        $users = file_get_contents($file);

        return json_decode($users, true);
    }

    /**
     * Read Json file this will be good
     * for large files so we will read the file 
     * line by line 
     * @return array
     */
    public function complexRead()
    {
        $file = storage_path('json/'.$this->path);
        $handle = fopen($file, "r");
        $current = 0;
        $i = 0;
        $usersList = [];
        $user = "";

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                
                if ($this->skip  > 0) {
                    $this->skip--;
                } else {
                    $current++;
                    $user .= $line;
                }
                
                /**
                 * Database transaction goes here instead of 
                 * adding data to array
                 */
                if ($current == $this->size) {
                    $user = str_replace("},", "}", $user);
                    $usersList[$i] = json_decode($user, true);
                    $user = "";
                    $i++;
                    $current = 0;
                }
            }
            
            fclose($handle);
        }

        return $usersList;
    }

    public function saveImport()
    {
        return DB::transaction(function () {

                $users = $this->read();
                $users = $users['users'];
                
                foreach ($users as $key => $user) {
                    $validator = $this->validate($user);

                    if ($validator->fails()) {
                        //log error something wrong with 
                        //file
                    } else {
                        $user['provider'] = $this->name;
                        User::create($this->transfer($user));
                    }
                }
        });
        
    }

    public abstract function validate($user);
    
    public abstract function transfer($user);

    public function getStatus($code)
    {
        /**
         * Better to be Enum 
         * but need to find solution for duplicates 
         *
         */
        $codes = [
            1 => "authorised",
            2 => "decline",
            3 => "refunded",
            100 => "authorised",
            200 => "decline",
            300 => "refunded",
        ];

        return $codes[$code];
    }
 }  