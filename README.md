# Laravel/Symfony Simple Test

Please create a simple Laravel/Symfony/(Any other framework you like) site where a user will be able to provide his city and country via form and after submission system will display current weather forecast.
Forecast temperature should be calculated as an average based on different APIs, at least 2 different data sources (ex. API1 will return temperature 25, API2 will return temperature 27 so the result should be 25+27/2 ie. 26)
Feel free to use [Open Weather API](https://openweathermap.org/api) and any other API you like.

Few notes:

-   please implement proper error handling
-   results should be stored in the database
-   a simple caching mechanism should be added
-   ability to easily add new data sources (how to register them, interfaces etc.)
-   clean data separation
-   nice to have - latest PHP mechanisms (ex. traits)

Once done, please either pack the whole code or provide a link to a public repository.

---

## Solution that I came-up wth:

-   Front-end was developed using Angular 9
-   Can be accessed using [this](http://phplaravel-345873-1358814.cloudwaysapps.com/) link
-   Weather API responses are cached for just 1 minute so we can test quickly if caching works
-   Also, cache is loaded from memory using Redis
-   Can easily add more weather data sources using the [Adapter Pattern](https://en.wikipedia.org/wiki/Adapter_pattern) (directions written below)
-   Weather API responses are turned into `WeatherData` model an then saved into the database
-   Etc.
-   Some features are partially implemented (authentication for associating results with a user, admin account for adding new data sources via the front-end, etc...) but I was not able to complete them due to the fact that I still have a full-time day job a the time of this exam

### How to use this simple web app:

1.  Go to [this](http://phplaravel-345873-1358814.cloudwaysapps.com/) link to open the web app.
2.  Change the location for the weather data (set to "Banilad, Mandaue, Philippines" by default) by clicking the gear icon on the bottom-right corner of the screen and changing the location on the modal's input field.
3.  Press the enter key or click the "Save" button and wait for the new weather data to be fetched.

### How to add Weather APIs:

1.  Create a new class on `app\Services` directory. This class should implement the `getData` method from `\App\Contracts\WeatherProvider` interface which should return a `App\WeatherData` instance.
2.  Add the created class to the `Providers\AverageWeatherServiceProvider` service provider's `register` method where it says `'// Append additional weather sources here'`.
