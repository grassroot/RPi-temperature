# RPi-temperature

## Description

Scripts related to Raspberry Pi temperature logger project for reading temperature values from DS18B20 sensor device and reading the data forward to Zabbix monitoring system.

## Status

- Scripts work
- Frontend stuff basically works, although there are some work (and ideas) still left.

## Contents

__data/__:
  - The database location

__http/__:
  - Frontend made with [Yii](http://www.yiiframework.com/).

__scripts/w1-temp__:
  - reads a value from the sensor and writes it to STDOUT

__scripts/w1-store-temp__:
  - Creates a new SQLite database if it does not already exist
  - Inserts the value to the database

__README.md__:
  - This README

## Installation

Assumption is that you have the Raspberry Pi (naturally) fixed with One Wire temperature sensor (DS18B20) to report temperature values. Read [here](http://humbletux.blogspot.com/2012/12/yet-another-raspberry-pi-temperature.html) about my setup.

- Install required packages: `sudo apt-get install sqlite3 git apache2`.

- Download the project

<pre>
    $ cd /opt
    $ sudo mkdir RPi-temperature
    $ sudo chown pi:pi RPi-temperature
    $ git clone git://github.com/grassroot/RPi-temperature.git
</pre>
    
- Change Apache's default webroot to point into application directory by modifying file `/etc/apache2/sites-available/default`:
    - Modify `DocumentRoot /var/www` to `DocumentRoot /opt/RPi-temperature/http/application`.
    - Modify `<Directory /var/www>` to `<Directory /opt/RPi-temperature/http/application>`.
    - Reload the apache configuration: `sudo /etc/init.d/apache2 reload`.

- Add a following lines to your crontab to store the temperature values to the database. The script will create the database under data/ at first run.
<pre>
    # Store temperature values to the database every 10 minutes
    */10 * * * * /opt/RPi-temperature/scripts/w1-store-temp
</pre>

- Run the store-script manually to initialize the database and make sure it works.

- Modify the database file and directory for Apache to be able to access it properly.
<pre>
    $ cd /opt/RPi-temperature
    $ sudo chgrp -R www-data data
    $ sudo chmod g+w -R www-data data
</pre>

- With your favorite browser, locate to the Pi's IP-address, and you should see a home page listing the latest temperature values.

- Go to Locations-page and change the current location of the Pi.

Datz it, enjoy :-)

