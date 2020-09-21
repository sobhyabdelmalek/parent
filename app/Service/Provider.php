<?php

namespace App\Service;

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

    public abstract function saveImport(); 
    public abstract function validate(); 
 }  