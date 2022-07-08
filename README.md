# Telegram-JotForm-ChatBot
This is my first internship project which is Telegram based chatbot system for JotForm company.
![Jotform_logo](https://user-images.githubusercontent.com/58821198/178030039-9407bd55-3d6c-4e5c-a1d6-e2df1d5f569d.png)

 There are several features and steps in this project

# Connection
This system is used with NGROK for sending and receiving GET/POST requests from Telegram API.

# Database
There are no database integration, it creates small .txt files for storage. Adding a database will be unnecessary for the project that's why I used .txt files like a small caches.

# Features
There are several features in the chatbot system
--> User can create a form with logging their JotForm account. After creating a form, user can share this form link to the other telegram users.
--> User can fill a created form using Telegram. However, this form should be created with chatbot. If user create a form on JotForm website, chatbot will not respond.
--> User can check their current forms and current answers to their forms.
