RPi-temperature
===============

Scripts related to Raspberry Pi temperature logger project for reading temperature values from DS18B20 sensor device and reading the data forward to Zabbix monitoring system.

__w1-temp__:
  - reads a value from the sensor and outputs it to STDOUT

__w1-store-temp__:
  - Creates a new SQLite database if it does not already exist
  - Inserts the value to the database

Read more about how these were used from here: <http://humbletux.blogspot.com/2012/12/yet-another-raspberry-pi-temperature.html>.
