<?php

include_once $_SERVER['DOCUMENT_ROOT']."/JotForm.php";
include_once $_SERVER['DOCUMENT_ROOT']."/Storage.php";

/* create_form function is creating new form and send 
createForm() request when user type '/end'. 
*/

function create_form($chatID){
        $file = fopen($chatID."create_form.txt" , "r");
        $command = fgets($file);
        if($command != NULL){
            $title = $command;
            
        }
        $form = array(
            'questions' =>array(
            array(
                'type' => 'control_head',
                'text' => $title,
                'name' => 'Header',
            )),
            'properties' => array(
                'title' => $title,
                'height' => '600',
            ),
            'emails' => array(
                array(
                    'type' => 'notification',
                    'name' => 'notification',
                    'from' => 'default',
                    'to' => 'noreply@jotform.com',
                    'subject' => 'New Submission',
                    'html' => 'false'
                ),),);
        
        while(!feof($file)){
            $command = fgets($file);
            if( $command == "1".PHP_EOL){
                $form['questions'][] =
                    array(
                        'type' => 'control_fullname',
                        'text' => 'Full Name',
                        'name' => 'Full Name',
                        'validation' => 'None',
                        'required' => 'No',
                        'readonly' => 'No',
                        'size' => '20',
                        'labelAlign' => 'Auto',
                        'hint' => '',
                    );
               
            }
            else if( $command == "2".PHP_EOL){
                $form['questions'][] =
                    array(
                        'type' => 'control_email',
                        'text' => 'Email',
                        'name' => 'Email',
                        'validation' => 'None',
                        'required' => 'No',
                        'readonly' => 'No',
                        'size' => '20',
                        'labelAlign' => 'Auto',
                        'hint' => '',
                    );
                
                
            }
            else if( $command == "3".PHP_EOL){
                $form['questions'][] =
                    array(
                        'type' => 'control_textbox',
                        'text' => 'Address',
                        'name' => 'Address',
                        'validation' => 'None',
                        'required' => 'No',
                        'readonly' => 'No',
                        'size' => '20',
                        'labelAlign' => 'Auto',
                        'hint' => '',
                    );
              
            }
            else if( $command == "4".PHP_EOL){
                $form['questions'][] =
                    array(
                        'type' => 'control_phone',
                        'text' => 'Phone Number',
                        'name' => 'Phone Number',
                        'validation' => 'None',
                        'required' => 'No',
                        'readonly' => 'No',
                        'size' => '20',
                        'labelAlign' => 'Auto',
                        'hint' => '',
                    );
                }
            }
        $form['questions'][]=
                    array(
                        'type' => 'control_button',
                        'text' => 'Submit ',
                        'name' => 'Submit',
                        'validation' => 'None',
                        'required' => 'No',
                        'size' => '20',
                        'labelAlign' => 'Auto',
                        'hint' => '',
                    );
        fclose($file);
/* Send create form request to jotform.com */
        $apifile = fopen($chatID."api.txt" , "r");
        $api = fgets($apifile);
        $jotformAPI = new JotForm($api);
        $response =$jotformAPI->createForm($form);
        $str = explode("/" , $response['url']);
        return "You can see your form ".$response['url']."\r\nShare with your friend, with this url people can fill your form https://t.me/jotform_bot?start=submission_".$str[3]
            ."\r\nYou can see your submissions with this url https://t.me/jotform_bot?start=get_".$str[3];
}

