<?php
include "command.php";
include_once "Storage.php";
include "create_form.php";
include "submission.php";
include "information.php";

/* basic connection part on telegram 
$update is main part of the connection on telegram
*/
$token = ####### (token-key, it is deleted due to privilege);
$website = "https://api.telegram.org/bot".$token;
$web = "https://api.telegram.org/file/bot".$token;
$update = file_get_contents('php://input');
$update = json_decode($update , TRUE);
$chatID = $update['message']['from']['id'];
$firstname = $update['message']['from']['first_name'];
$username = $update['message']['from']['username'];
$text = $update['message']['text'];
$ngrok = ##### (ngrok URL, it is deleted due to privilege);

/* Send Message function which is coming from api.telegram */
function sendMessage($chatID , $text){
    $url = "https://api.telegram.org/bot1296708550:AAFcfS9g3UdqNM6jazSNQbVnVR8v85364uY/sendMessage?chat_id=".$chatID."&text=".urlencode($text);
    file_get_contents($url);
}
$command = new command();
$cache = new Storage();
$chat = FALSE;



/* if create_form.txt is empty thats mean user doesn't give Title of form so with this if clause bot will wait 
to respond for title */
if(empty($cache->getInfo($chatID."create_form.txt"))){
    if($cache->getInfo($chatID."cache.txt") == "/create_form"){
    $cache->progress($chatID , $chatID."create_form.txt" , $text);
    $form_title = $text;
    $chat = TRUE;

    }
}
//--------------------------------CREATE FORM PART-------------------------------------------

/* if create_form.txt is not empty thats mean user gave title of form so this if clause triggers steps of createForm 
if user type '/end' then createForm questions will stop and bot will create from */
if(!empty($cache->getInfo($chatID."create_form.txt")) && $text != "/end" && $text != "/done"){
    sendMessage($chatID, "What do you want in your form \r\n1 Full Name Field \r\n2 Email Field \r\n3 Address Field \r\n4 Phone Number Field \r\nYou can type just number (1 2 etc.) \r\nType '/end' for complete form ");

    if($text == "1" || $text == "2" || $text == "3" || $text == "4" || $text == $form_title){
    $cache->progress($chatID , $chatID."create_form.txt" , $text);
    }
    else{
        sendMessage($chatID , "Wrong format please type just number between 1-4");
    }
    $chat = TRUE;
}
/* This project have 2 txt file, cache.txt and create_form.txt when user type '/create_form' cache.txt is saving this type for 
starting create_form.php*/
if($text == "/create_form" && !empty($cache->getInfo($chatID."api.txt"))  ){
    $cache->Start($chatID , );
    $cache->progress($chatID , $chatID."cache.txt" , $text);
    sendMessage($chatID , "Alright, Lets start \r\nPlease type form title");
    $chat = TRUE;
}
if($text == "/create_form" && empty($cache->getInfo($chatID."api.txt")) ){
    sendMessage($chatID , "First, you have to login to system.");
    sendMessage($chatID , "You can login from here: ".$ngrok."/login.html");
    $chat = TRUE;
}

/* Normally '/end' command should be in command.php it will be added when some steps are completed 
when user type '/end' cache files are deleted and create_form() which is comming from create_form.php method  starts */
if($text == "/end" && $cache->getInfo($chatID."cache.txt") != "submission" && $cache->getInfo($chatID."cache.txt") == "/create_form"){
    sendMessage($chatID , create_form($chatID));
    $cache->End($chatID);
    sendMessage($chatID, "Form created succesfully");
    sendMessage($chatID ,"That was a wonderful form well done :) , you can chat with me if you want or just type /help if you need help");
    $chat = TRUE;
}
else if($text == "/end" && $cache->getInfo($chatID."cache.txt") == "/start"){
    sendMessage($chatID, "Uncorrect command did you want to type '/done' ? ");
    $chat = TRUE;
}
//-------------------------------CREATE FORM PART--------------------------------------------


//-------------------------------FORM SUBMISSION PART----------------------------------------------

/* When user type '/done' system will closed and Send() method will run which is coming from submission.php */
if($text == "/done" && $cache->getInfo($chatID."cache.txt") != "/create_form" && $cache->getInfo($chatID."cache.txt") == "submission"){
    sendMessage($chatID , Send($chatID));
    $cache->End($chatID);
    sendMessage($chatID , "Form response has been received");
    sendMessage($chatID , "You can type /create_form for create new form or you can chat with me :) type /help if you need help");
    $chat = TRUE;
}
else if($text == "/done" && $cache->getInfo($chatID."cache.txt") == "/create_form"){
    sendMessage($chatID, "Uncorrect command did you want to type '/end' ? ");
    $chat = TRUE;
}


/* seperated $text message for "1 Name Surname" or "2 example@example.com" answers*/
$data = explode(" " , $text);
$data2 = explode("_" , $data[1]);

/* submission command working with '/start /submission form_number' so when user enter this command, /submission command adding into cache.txt
and response.txt saving Form ID number */
if($data2[0] == "submission" && is_numeric($data2[1]) == 1){
    $cache->Start($chatID);
    $cache->progress($chatID , $chatID."cache.txt" , $data2[0]);
    $cache->progress($chatID , $chatID."response.txt" , $data2[1]);
    sendMessage($chatID , question($chatID , $data2[1]));
    response($chatID);
    $chat = TRUE;
}
/* After user used /submission command bot will ask question of form question and added into response.txt of user answers this if clause will user if user type '/end' 
or '/done' */
if($cache->getInfo($chatID."cache.txt") == "submission" && $text != "/done" && $text != "/end"){
    $lines = file($chatID."response.txt");
    if($text == "/clear"){
        file_put_contents($chatID."response.txt" , "");
        file_put_contents($chatID."response.txt" , $lines[0] , FILE_APPEND);
        response($chatID);
        sendMessage($chatID , "Your submission response has been deleted and starting again.");
    }
        $lines = file($chatID."response.txt");
        $formid = fgets($chatID."response.txt",16);
        file_put_contents($chatID."response.txt" , "");
        sendMessage($chatID , "Type /done for complete submission or type /clear for start again submission");
        for($x = 0; $x < count($lines); $x++){
            $word = explode("." , $lines[$x]);
                if($word[0] == 1 && $word[1] =="f".PHP_EOL){
                    $lines[$x] = "1.Fullname\r\n";
                    sendMessage($chatID ,"Please type your Full Name");
                    break;
                }
                else if($word[0] == 1 && $word[1] == "Fullname\r\n"){
                    $lines[$x] ="FullName ".$text."\r\n";
                }
                if($word[0] == 2 && $word[1] =="e".PHP_EOL){
                    $lines[$x] = "2.Email\r\n";
                    sendMessage($chatID , "Please type your email");
                    break;
                }
                else if($word[0] == 2 && $word[1] == "Email\r\n"){
                    $lines[$x] = "Email ".$text."\r\n";        
                }
                if($word[0] == 3 && $word[1] == "p".PHP_EOL){
                    $lines[$x] = "3.PhoneNumber\r\n";
                    sendMessage($chatID , "Please type your phone number");
                    break;
                }
                else if($word[0] == 3 && $word[1] == "PhoneNumber\r\n"){
                    $lines[$x] = "PhoneNumber ".$text."\r\n";
                }
                if($word[0] == 4 && $word[1] == "a".PHP_EOL){
                    $lines[$x] = "4.Address\r\n";
                    sendMessage($chatID , "Please type your Address in one message ex: Eagle street ,sky house ,number 30 London/England");
                    break;
                }
                else if($word[0] == 4 && $word[1] == "Address\r\n"){
                    $lines[$x] ="Address ".$text."\r\n";
                }

            }       
        file_put_contents($chatID."response.txt" , $lines , FILE_APPEND);
        $chat = TRUE;

} 
//------------------------FORM SUBMISSION PART-------------------------------------------


//-----------------------GET SUBMISSION PART---------------------------- 
// After succesfull login the system, users can use '/get' command and with this command user can see their forms numerically and after selecting one form they can see form submissions.   
if($cache->getInfo($chatID."cache.txt") == "/get"){
    sendMessage($chatID , information($chatID , $text));
    $cache->End($chatID);
    sendMessage($chatID , "You can say again /get and give number to see another form submissions or say /create_form for creating new form :)");
    $chat = TRUE;
}
//---------------------------GET SUBMISSION PART-----------------------

// This is submission part if user type correct command, bot will respond all submission of form
// -----------------LOGIN SYSTEM PART--------------------------------

if($text == "/get" && !empty($cache->getInfo($chatID."api.txt"))){
    sendMessage($chatID , getform($chatID));
    $cache->progress($chatID , $chatID."cache.txt" , $text);
    $chat = TRUE;
}
if($text == "/get" && empty($cache->getInfo($chatID."api.txt"))){
    sendMessage($chatID , "First, you have to login to system.");
    sendMessage($chatID , "You can login from here: ".$ngrok."/login.html");
    $chat = TRUE;
}


if($data2[0] == "api"){
    $cache->Start($chatID);
    sendMessage($chatID , "Welcome to Jotform Telegram Bot again, now you can create new form with /create_form command or you can see your form submission with /get command. You can sign out with /signout command");
    $cache->progress($chatID , $chatID."api.txt" , $data2[1]);
    $chat = TRUE;

}
if($text == "/signout"){
    $cache->out($chatID);
    sendMessage($chatID , "You successfully signed out. See you soon :)");
    $chat = TRUE;
}

// --------------------LOGIN SYSTEM PART------------------------------------------

// This if clause just like a debug because bot sometimes get confuse about response 
if(!$chat){
    sendMessage($chatID, $command->commandlist($text , $firstname));
}

?>



