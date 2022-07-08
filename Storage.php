<?php

/* Storage.php is the cache class of bot system, this system creating and deleting txt files with /create_form and /end commands */
// Update: Storage system is changed, Bot will save files according to chatID and username
class Storage{

    public function Start($chatID){
        file_put_contents($chatID."cache.txt");
        file_put_contents($chatID."create_form.txt");
        file_put_contents($chatID."question.txt");
        file_put_contents($chatID."response.txt");
        file_put_contents($chatID."api.txt");
        ob_start();

    }
    public function progress($chatID ,$file , $msg){
        if($file == $chatID."cache.txt" || $file == $chatID."api.txt"){
        file_put_contents($file , $msg);
        }
        else{
            file_put_contents($file , $msg."\r\n" , FILE_APPEND);
        }
    }
    
    public function End($chatID){
        unlink($chatID."cache.txt");
        unlink($chatID."create_form.txt");
        unlink($chatID."question.txt");
        unlink($chatID."response.txt");
        ob_clean();
    }
    public function out($chatID){
        unlink($chatID."api.txt");
    }
    public function getInfo($file){
        return file_get_contents($file);
    }

    

}