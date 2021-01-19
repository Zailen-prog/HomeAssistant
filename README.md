# HomeAssistant
Project made for IT class
## Description
Web site that is connected to Arduino with help of EPS8266-01s module.</br>
On web site we can display data collected from sensor and controll relays.
# Instructions
## How to open project on your machine
### If you are not familiar with XAMPP and phpmyadmin go to this [section](###To-set-up-with-server-on-your-machine)
1. 
First download all the files from repesitorium and unpack them.</br>
Now you need server for website as well as database.</br>
You can use hosting from 3rd party company and deploy webstite there or just setup local server on your machine.</br>
### To set up with server on your machine:
1. Download [XAMPP](https://www.apachefriends.org/pl/download.html) and install it.
2. Open it, you should see this window </br><img src="https://user-images.githubusercontent.com/76070960/104770409-d1a2e780-5770-11eb-8cfb-d4f2ad602884.png">
3. To start server and database press Start for module Apache and MySQL.
### Configure database and website
1. Press Admin for MySQL or just type [localhost/phpmyadmin](http://localhost/phpmyadmin) in your browser.
2. You should see this <img src="https://user-images.githubusercontent.com/76070960/104772493-ce5d2b00-5773-11eb-8cbb-bf5a1d0d9d7d.png"> 
3. Press New on the right side, choose Database name (you can use whatever but I prefer *homeassistant* that way you wont have to change anything in the files) then press Create.</br> <img src="https://user-images.githubusercontent.com/76070960/104773188-f436ff80-5774-11eb-81e0-e4f529ebe77f.png">
* If you chosen diffrent name go to `website/db_handlers/db_connection.php` and edit `$db` to your db name
4. Now you have to import file with all tables and some data. Make sure you have selected correct database and press Import <img src="https://user-images.githubusercontent.com/76070960/104773681-b7b7d380-5775-11eb-842d-e09f63867add.png">
5. Now search for `homeassistant.sql` file and then press Go. It should add 3 tables (data, relays and users) to your database.
6. Now you have to put all the files and folders from `website` folder to root of our sever, to do that go to this directory `C:\xampp\htdocs` and copy all the files there.</br>
If for some reason you cant find this directory open your XAMPP and press Config for Apache and press Apache(httpd.conf), file `httpd.conf` should open, search for this specific section <img src="https://user-images.githubusercontent.com/76070960/104775656-0024c080-5779-11eb-81f0-26657fe7653d.png"></br> Whatever directory there is, it's your root directory, you can change it if you want just make sure to put all the website files there.

Now everything should work, you should be able to go to the website, just type [localhost](localhost) in your browser.</br>
You can use this link [http://localhost/db_handlers/save_data.php?id=Test123&Temp=27&Humidity=26](http://localhost/db_handlers/save_data.php?id=Test123&Temp=27&Humidity=26) to insert new data where `Test123` is account login.</br>
You can use this link [http://localhost/db_handlers/send_to_esp.php?id=Test123](http://localhost/db_handlers/send_to_esp.php?id=Test123) to get states of relays where `Test123` is account login.
### Set up Arduino and ESP8266
1. If you use DHT11 sensor you don't need to change anything in the code, just make sure to download `DHT11.h` and `ArduinoJson.h` library</br> <img src="https://user-images.githubusercontent.com/76070960/104787580-22760880-5790-11eb-98d3-52000c700c9a.png"></br><img src="https://user-images.githubusercontent.com/76070960/104787643-58b38800-5790-11eb-8e47-bb6534396d9d.png"></br>If you use other temp and humidity sensor make sure to edit code to suit your sensors.
2. For ESP first go to `File -> Preferences` and add this to Additional Board Manager URLs [http://arduino.esp8266.com/stable/package_esp8266com_index.json](http://arduino.esp8266.com/stable/package_esp8266com_index.json)
3. Go to `Tools -> Board -> Boards Manager` and download esp8266 board manager <img src="https://user-images.githubusercontent.com/76070960/104788154-c2806180-5791-11eb-8544-c307c9eb3b9f.png">
4. Download `WiFiManager.h` library </br> <img src="https://user-images.githubusercontent.com/76070960/104788264-2f93f700-5792-11eb-9c67-3af7e861ff3b.png">
5. Now you need to change ip of your local server in urls </br><img src="https://user-images.githubusercontent.com/76070960/104788352-679b3a00-5792-11eb-8b11-969afb29c6e0.png"></br> Change `192.168.1.2` to your local ip. If you don't know your local ip open CMD and type `ipconfig` and press enter</br> <img src="https://user-images.githubusercontent.com/76070960/104788612-e7c19f80-5792-11eb-92c0-4d586faef81d.png"></br>Look for `IPv4 Address` of your connetion</br><img src="https://user-images.githubusercontent.com/76070960/104788840-8cdc7800-5793-11eb-9a49-b078578126fb.png">
6. Once you do all of this upload code to ESP.

* When your ESP starts up, it sets it up in Station mode and tries to connect to a previously saved Access Point
* if this is unsuccessful (or no previous network saved) it moves the ESP into Access Point mode (`name: ESP8266, password: HomeAssistant`) and spins up a DNS and WebServer (default ip 192.168.4.1)
* using any wifi enabled device with a browser (computer, phone, tablet) connect to the newly created Access Point
* because of the Captive Portal and the DNS server you will either get a 'Join to network' type of popup or get any domain you try to access redirected to the configuration portal
* choose one of the access points scanned, enter password, click save
* ESP will try to connect. If successful, it relinquishes control back to your app. If not, reconnect to AP and reconfigure.

Now connect Arduino with ESP (Arduino TX connect to ESP RX, ESP TX connect to Arduino RX)
If you did everyhing correct it should send data to your website.

### Autors
Sebastian Nowak </br>
Julia Palichleb
