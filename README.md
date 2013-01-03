# RPi-temperature

## Description

Scripts related to Raspberry Pi temperature logger project for reading temperature values from DS18B20 sensor device and reading the data forward to Zabbix monitoring system.

Read more about how these were used from [here](http://humbletux.blogspot.com/2012/12/yet-another-raspberry-pi-temperature.html).

## Status

- Scripts work
- Frontend stuff does not work yet

## Contents

__data/__:
  - The database location

__http/__:
  - Frontend stuff

__scripts/w1-temp__:
  - reads a value from the sensor and outputs it to STDOUT

__scripts/w1-store-temp__:
  - Creates a new SQLite database if it does not already exist
  - Inserts the value to the database

__README.md__:
  - This README

## Prerequisites

- Raspberry Pi (naturally) fixed with One Wire temperature sensor (DS18B20) to report temperature values. Read [here](http://humbletux.blogspot.com/2012/12/yet-another-raspberry-pi-temperature.html) about my setup.
- Required packages: sqlite3

## Installation

- Add a following lines to your crontab to store the temperature values to the database

    \\# Store temperature values to the database every 10 minutes
    */10 * * * * /opt/RPi-temperature/scripts/w1-store-temp

