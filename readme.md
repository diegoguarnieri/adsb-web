## About

This project was designed to be a web interface for data received from ADS-B receivers.

We have 3 main pieces in this project. 

- App\Apps\Routines\feed.php: this script was created to read the port 30003/tcp which is a brodcast with the ADS-B data. This broadcast should be created using a software called dump1090 which is not part of this project.
- API ingestion: this api was created to receive the data sent from the feed.php script. It'll save this data on a instance of a MongoDB and send a copy of this data to a websocket developed in Node.js.
- UI: this user interface was created using Vue.js and displays all the stats and most recent flights received on the API.

## Install

*To install this project, you should have an instance of MongoDB running.

git clone https://github.com/diegoguarnieri/adsb-web.git
composer install
npm run dev

Change the file .env with your local DB configurations.

## TODO

- Improve the dashboard stats
- Create the test routines for all classes

## License

The project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
