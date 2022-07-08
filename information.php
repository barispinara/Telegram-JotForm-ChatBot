<?php
include_once "JotForm.php";

//This is submission class of $Jotform_bot it reading all submission and adding into $data string
function getform($chatID){
    $fileapi = fopen($chatID."api.txt" , "r");
    $api = fgets($fileapi);
    $jotformAPI = new JotForm($api);
    $forms = $jotformAPI->getForms();
    $message .= "Which form would you like see submissions type a number\r\n";
    for($x = 1; $x<=count($forms); $x++){  
        if($forms[$x]['title'] != NULL){
            $message .= ($x)." ".$forms[$x]['title'];
        }
    }
    return $message;
}

function information($chatID , $number){
    $fileapi = fopen($chatID."api.txt" , "r");
    $api = fgets($fileapi);
    $jotformAPI = new JotForm($api);
    $forms = $jotformAPI->getForms();
    $submission = $jotformAPI->getFormSubmissions($forms[$number]['id']);
    for($x = 0; $x<count($submission); $x++){
        for($i = 1; $i < count($submission[0]["answers"]); $i++){
            if($submission[$x]["answers"][$i]["text"] =="Full Name" ){
                $data .= "Full Name: ".$submission[$x]["answers"][$i]["prettyFormat"];
            }
            else if($submission[$x]["answers"][$i]["text"] == "Phone Number"){
                $data .= "Phone Number: ".$submission[$x]["answers"][$i]["answer"];
            }
            else if($submission[$x]["answers"][$i]["text"] == "Email"){
                $data .= "Email: ".$submission[$x]["answers"][$i]["answer"];
            }
            else if($submission[$x]["answers"][$i]["text"] == "Address"){
                $data .= "Address: ".$submission[$x]["answers"][$i]["answer"];
            }
            else if($i == 1){
                $data .= "Form Title: ".$submission[$x]["answers"][$i]["text"];
                $data .= "Submission Date: ".$submission[$x]['created_at']."\r\n";
            }
        }
        $data .= "\r\n";
    }

    if($data = "\r\n"){
        $data .= "This form doesn't have any submission.";
    }

    return $data;
}