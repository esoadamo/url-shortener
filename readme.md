# URL Shortener

The most basic url shortener, uses JSON file as a database.

## Instalation

1. Copy shortener.php to your web server
2. Adjust settings
3. Have fun

## Settings

### shortened_url_prefix

Here you should put the URL that points to this scripts. Be sure that it will start with slash ('**/**')

### count_random_characters

How many random characters will be inside short URL. Final length of your short URL is **shortened_url_prefix** + **count_random_characters**

### data_file

File where your database will be saved

### url_404

URL where user will be redirected when he enters a non-existing short URL

### use_ssl

When set to true then returned short URL starts with *https://* instead of *http://*

### api_key

This is the key parameter that you send with the request for new short URL to prove that sender is really you.

### settings_done

After you finished your configuration, set this to true and your script will become functional.

## Usage

to create new short URL call this script with two parameters:

- **link** - the long URL
- **key** - your api_key

you can check the example written in Python