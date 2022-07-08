<?php

/* basic Command class, it shows all commands of bot*/

class command {
function commandlist ($msg , $firstname) {
    $msg = mb_strtolower($msg , 'UTF-8');

    switch($msg){

    case"hello":
        return "Hi ".$firstname.", welcome to Jotform. I'm your assistant for Jotform. You can easily create new form with me if you want to create form just say /create_form";
    case"hi":
        return "Hi ".$firstname.", welcome to Jotform. I'm your assistant for Jotform. You can easily create new form with me if you want to create form just say /create_form";
    case"how are you":
        return "I'm Fine ".$firstname;
    case"merhaba":
        return "Merhaba ".$firstname." üzgünüm ama ben şuanlık Türkçe bilmiyorum Hello diyebilirsin :)"; //", Jotform'a hoşgeldin, Jotform için senin yeni asistanınım. Bana vereceğiniz komutlarla form oluşturabilirsin başlamak için /create_form yazman yeterli";
    case"/start":
        return "Welcome JotForm Bot please say Hello for a good start :)";
    case"/help":
       return "/create_form for new create new form \r\n/start submission_{form-id} for submission to form \r\n/start get_{form-id} for see submissions of form";
    case"where are you from":
        return "I'm from Silicon Valley :)";
    case"where are u from":
        return "I'm from Silicon Valley :)";
    case"i need help":
        return "/create_form for new create new form \r\n/start submission_{form-id} for submission to form \r\n/start get_{form-id} for see submissions of form";
    case"jotform":
        return "Jotform is a online form builder , millions of people are using jotform for creating new forms.";
    case"what is jotform":
        return "Jotform is a online form builder , millions of people are using jotform for creating new forms.";
    case"what is this jotform":
        return "Jotform is a online form builder , millions of people are using jotform for creating new forms.";
    case"what is the jotform":
        return "Jotform is a online form builder , millions of people are using jotform for creating new forms.";
    case"thank you":
        return "You're welcome, see you soon";
    case"thanks":
        return "You're welcome, see you soon";
    case"have a good day":
        return "You too";
    default:
       return "I don't know what's that mean ".$firstname." you can just say hello or merhaba for a good start :)";
    }

}

}