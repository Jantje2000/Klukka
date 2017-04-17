# Klukka
Klukka is a time registration system that you can use to check how many hours your employees worked.

You can setup this time registration system sure. You have to follow my points:

# Setting up the database
1. Make a new database
2. Run here the SQL code out of page database.sql in PHPMyADMIN. Now you are having the database structure

# Setting up the web-interface

1. In the page "dbconfig.php" you have to add your own database properties. So you have to fillin your host-address, your database name, your database password and username.
2. In the page "addtime.php" you have also to add your own database properties.
3. If you want to use this system to print payslips then you have to add the API key in the page "PHPToPDF.php" on line 4. This API key could you find on <a href="https://phptopdf.com/">phptopdf.com</a>. 
4. If you want to use the payslip then you have to fill in the data of your company. This is possible in "get_loonstrook.php" at line 52-54. Here you can personalize the payslip.
5. THIS POINT IS ONLY INTENDED FOR PEOPLE IN THE NETHERLANTHS! <br /> If you are living in the Netherlanths you can get an API key at <a href="https://postcodeapi.nu">postcodeapi.nu</a> that you have to fill in at "getaddress.php" on line 6. Then will the addresses fill in automatically if you are adding a new user.

# Setting up the RFID reader. This is possible with Arduino and Raspberry Pi.

# Setting up with Raspberry Pi

1. First you need a RC522 RFID Reader
2. You have to connect this reader to the raspberry as following: <br /> <img src="https://github.com/Jantje2000/Klukka/blob/master/raspberry.png?">
3. At your raspberry pi enable the SPI interface. (Start -> Preferences -> Raspberry Pi configuration -> Interfaces
4. Reboot your raspberry pi
5. Then you need the SPI library, so run the following command in the terminal : "sudo apt-get install python-dev"
6. Download SPI-Py from Github with the following command: "git clone https://github.com/lthierry/SPI-Py.git"
7. Set SPI-Py usable for Python: "sudo python setup.py install"
8. Now save the file raspberry.py anywhere and change on line 43 the domain name of the website where you want to send the request.
9. Now run this programm and you can use this for clocking your employees

# Setting up with Arduino

1. 1. First you need a RC522 RFID Reader
2. You have to connect this reader to the arduino as following: <br /> <img src="https://github.com/Jantje2000/Klukka/blob/master/arduino.png?">
3. Load the file rfid.ino on your arduino IDE.
