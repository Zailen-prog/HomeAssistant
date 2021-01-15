# HomeAssistant
Project made for IT class
## Description
Web site that is connected to Arduino with help of EPS8266-01s module.</br>
On web site we can display data collected from sensor and controll relays.
# Instructions
## How to open project on your machine
First download all the files from repesitorium and unpack them.</br>
Now you need server for website as well as database.</br>
You can use hosting from 3rd party company and deploy webstite there or just setup local server on your machine.</br>
### To set up with server on your machine:
1. Download [XAMPP](https://www.apachefriends.org/pl/download.html) and install it.
2. Open it, you should see this window </br><img src="https://user-images.githubusercontent.com/76070960/104770409-d1a2e780-5770-11eb-8cfb-d4f2ad602884.png">
3. To start server and database press Start for module Apache and MySQL. Thats it.
### Configure database and website
1. press Admin for MySQL or just type [localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
2. You should see this <img src="https://user-images.githubusercontent.com/76070960/104772493-ce5d2b00-5773-11eb-8cbb-bf5a1d0d9d7d.png"> 
3. Press New on the right side, choose Database name (you can use whatever but I prefer *homeassistant* that way you wont have to change anything in the files) then press Create.</br> <img src="https://user-images.githubusercontent.com/76070960/104773188-f436ff80-5774-11eb-81e0-e4f529ebe77f.png">
4. Now you have to import file with all tables and some data. Make sure you have selected correct database and press Import <img src="https://user-images.githubusercontent.com/76070960/104773681-b7b7d380-5775-11eb-842d-e09f63867add.png">
5. Now search for `homeassistant.sql` file and then press Go. It should add 3 tables (data, relays and users) to your database.
6. Now you have to put all the files and folders from website folder to root of our sever, to do that go to thid directory `C:\xampp\htdocs` and copy all the files there.</br>
If for some reason you cant find this directory open your XAMPP and press Config for Apache and press Apache(httpd.conf), file `httpd.conf` should open, search for this specific section <img src="https://user-images.githubusercontent.com/76070960/104775656-0024c080-5779-11eb-81f0-26657fe7653d.png"></br> Whatever directory there is, it's your root directory, you can change it if you want just make sure to put all the website files there.

Now everything should work, you should be able to go to the website, just type [localhost](localhost) in your browser.</br>
You can use this link [http://localhost/db_handlers/save_data.php?id=Test123&Temp=27&Humidity=26](http://localhost/db_handlers/save_data.php?id=Test123&Temp=27&Humidity=26) to insert new data where `Test123` is account login.</br>
You can use this link [http://localhost/db_handlers/send_to_esp.php?id=Test123](http://localhost/db_handlers/send_to_esp.php?id=Test123) to get states of relays where `Test123` is account login.



### Autors
Sebastian Nowak </br>
Julia Palichleb
