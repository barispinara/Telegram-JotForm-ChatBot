<?php

include_once $_SERVER['DOCUMENT_ROOT']."/JotForm.php";
/* question method is reading all question in forms and adding into "question.txt" */
function question($chatID , $number){
    $jotformAPI = new JotForm("MASTER KEY");
    $response = $jotformAPI->getFormQuestions($number);
    for($i = 1 ; $i <= count($response) ; $i++){
        file_put_contents($chatID."question.txt" , $response[$i]['type']."\r\n" , FILE_APPEND);
    }
}
/* after reading all question response method asking answer for form question */
function response($chatID){
    $file = fopen ($chatID."question.txt" , "r");
    //$data;
    while(!feof($file)){
        $command = fgets($file);
        if($command == "control_fullname\r\n"){
            file_put_contents($chatID."response.txt" , "1.f".PHP_EOL , FILE_APPEND);
        }
        else if($command == "control_email\r\n"){
            file_put_contents($chatID."response.txt" , "2.e".PHP_EOL , FILE_APPEND);
        }
        else if($command == "control_phone\r\n"){
            file_put_contents($chatID."response.txt" , "3.p".PHP_EOL , FILE_APPEND);
        }
        else if($command == "control_textbox\r\n"){
            file_put_contents($chatID."response.txt" , "4.a".PHP_EOL , FILE_APPEND);
        }

    }
    fclose($file);
    //$data .= "Please Answer Like this \r\n '1 Name Surname' or \r\n '2 example@example.com' 4 \r\n type '/done' for complete submission";
    //return $data;

}
/* Send method is the final method of submission after gathering all answers which is coming from "response.txt" sending to JotForm*/
function Send($chatID){
    $file = fopen($chatID."response.txt" , "r");
    $form_number = fgets($file , 16);
    $jotformAPI = new JotForm("MASTER KEY");
    $response = $jotformAPI->getFormQuestions($form_number);
    $submission = array();
     while(!feof($file)){
            $command = fgets($file);
            $data = explode(" " , $command);
            if($data[0] == "FullName"){
                for($i = 1; $i<=count($response); $i++){
                    if($response[$i]['type'] == "control_fullname"){
                        $submission[$i."_first"] = $data[1];
                        $submission[$i."_last"] = $data[2]; 

                    }
                }
            }
            if($data[0] == "PhoneNumber"){
                for($i = 1; $i<=count($response); $i++){
                    if($response[$i]['type'] == "control_phone"){
                        $submission[$i] = $data[1]; 
                    }
                }
                
            }
            if($data[0] =="Email"){
                for($i = 1; $i<=count($response); $i++){
                    if($response[$i]['type'] == "control_email"){ 
                        $submission[$i] = $data[1]; 
                    }
                }
            }
            if($data[0] =="Address"){
                for($i = 1; $i<=count($response); $i++){
                    if($response[$i]['type'] == "control_textbox"){ 
                        $submission[$i] = $data[1]; 
                    }
            }
        }
            

    }
$result = $jotformAPI->createFormSubmission($form_number, $submission);
}

    
