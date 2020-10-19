# Weather App

Local forecast with detailed weather info, crowdsource weather data

# Screen
## Home Screen
![Home Screen](https://lh3.googleusercontent.com/pw/ACtC-3dc6TmwAfnjEH0-RIgHEtrHqHcSqwbD9bgXjRBX00phNGX3F-AaOdpFoQqT9JcQO53h6KjwdBpDehJhKbUItyqjOFhrig0Cj5ZWX84VaYscBxCwn3EG3-8nKyMDwluxodZvAVZLe-HMpBX28Kue6sJG=w674-h1434-no)

### City Placeholder
Get `name` from [current weather API](###Current)

### Current Weather Placeholder
Show `temp` on first row. Show `weather[0].description` on weather description on second row. Show `temp`/`feels_like` on third row.
All fileds can obtained from [current weather API](###Current)

### Forecast Placeholder
Show 6 forecast data from [forecast api](###Forecast). Show time, weather icon, `temp` and `feels_like` for each forecast

#### Weather Icon
Fetch weather icon from appending `weather.icon` to bellow base url
```curl
http://openweathermap.org/img/wn/{{weather_icon}}@2x.png
```
For example:
```
...
"weather": [
    {
        "id": 500,
        "main": "Rain",
        "description": "light rain",
        "icon": "10n"
    }
],
...
```
will have icon url: http://openweathermap.org/img/wn/10n@2x.png


### Sunrise and sunset illustration
Place sun icon along dashed line with according to `sys.sunrise` and `sys.sunset`. Animate sun movement from sunrise location to desired location

For example:
sunrise is on 5:32AM and sunset on 5:46PM. sun icon will be on top center of dashed line on 12:39PM. We got 12:39 PM from this formula:
```
sunrise + (sunset-sunrise)/2
```

## Login
![Login](https://lh3.googleusercontent.com/pw/ACtC-3dZW-9aJ5wqAMKjZ9wVkIIgHVzF7LZG-w3TyrSN9cB3T4_sSyA6KwtxLmYvqnrrPFT9izA8txezGMblzWd07raF9xLvw1aSntGR1oUn-sGvJSil80ENW9k96KPY1BBPfaeh47TufWJLo776B1rDlk2-=w680-h1440-no)

You can access this menu by click account icon on top left of homepage or loggin button on register page. Use appropriate input type for each fields. Save access token from [Login API](###Login) for uploading report in report page. Show error message if [Login API](###Login) returns error

## Register
![Register](https://lh3.googleusercontent.com/pw/ACtC-3cLSx8PhlnGYp4eYNIsjy3YWz3nCYQFqNnPPDs5Ph-UdsrNFjWt2G0J4DKankLYd_9Y2wW-wrIrnSh7JudbcgiqTMAR21UGIsd2Uomc5l-DTx34sVWeED5lmliu7183lsGyVGJ944ZaRZV7Dxj3qHSA=w674-h1448-no)

You can access this menu by click register button on [Login Page](##Login). Use appropriate input type for each fields.  Save access token from [Register API](###Register) for uploading report in report page. User should have password length must be greater than 5 and mixes of characters, numeric and symbols.

## Report
![Report](https://lh3.googleusercontent.com/pw/ACtC-3f-KB-qpdkFu0WbpmHC1OCCpzsXEIu21hPL5oBiR7RXXZM1TBGPyobSkt2LJm7FxeDGbwQRubN4JkZGvAgklTOB_zaxj1rWKiRigQEN_N2rNVj5S7WOyyjCQApgZb5vFJninmmwHjCtlmAv1ACDwKGx=w672-h1446-no)

You can access this page by click add icon/button on top right of homepage. Show logged in username in the greeting placeholder, ask user to login if access token is expired. Open gallery for user to select image when upload button / icon clicked. User should not upload file more than 10MB and only input temperature between -25 and 100.

# API

## Host
Use this host for all APIs
```
http://localhost:8000/api/v1
```

## Weather
### Current
- Path: `/weathers/current`
- Method: `GET`
- Params:
  1. lat - user's latitude
  2. lon - user's longitude
- Heades:
  1. `Accept` = `application/json`
- Response:
  1. temperature unit in celcius
  2. timestamp in UTC

  Sample:
  - Request:
  ```curl
  curl -X GET \
    'http://localhost:8000/api/v1/weathers/current?lat=-6.164713&lon=106.725050' \
    -H 'Accept: application/json' \
    -H 'Postman-Token: ccb7600f-484c-439f-afa9-e96e697d1927' \
    -H 'cache-control: no-cache'
  ```
  - Response:
  ```json
  {
      "data": {
          "coord": {
              "lon": 106.73,
              "lat": -6.16
          },
          "weather": [
              {
                  "id": 802,
                  "main": "Clouds",
                  "description": "scattered clouds",
                  "icon": "03d"
              }
          ],
          "base": "stations",
          "main": {
              "temp": 32.01,
              "feels_like": 34.09,
              "temp_min": 31,
              "temp_max": 32.78,
              "pressure": 1009,
              "humidity": 55
          },
          "visibility": 8000,
          "wind": {
              "speed": 3.6,
              "deg": 50
          },
          "clouds": {
              "all": 40
          },
          "dt": 1602994386,
          "sys": {
              "type": 1,
              "id": 9384,
              "country": "ID",
              "sunrise": 1602973827,
              "sunset": 1603017940
          },
          "timezone": 25200,
          "id": 1993378,
          "name": "Cideng",
          "cod": 200
      },
      "meta": {
          "version": "1",
          "hostname": "Komalas-MacBook-Pro.local",
          "client_ip": "127.0.0.1"
      }
  }
  ```
  
### Forecast
- Path: `/weathers/forecast`
- Method: `GET`
- Params:
  1. lat - user's latitude
  2. lon - user's longitude
- Heades:
  1. `Accept` = `application/json`
- Response:
  1. temperature unit in celcius
  2. timezone in UTC
 
  Sample:
  - Request:
  ```curl
  curl -X GET \
    'http://localhost:8000/api/v1/weathers/forecast?lat=-6.164713&lon=106.725050' \
    -H 'Accept: application/json' \
    -H 'Postman-Token: 38efce77-c68c-4747-9dfd-bef4068edd74' \
    -H 'cache-control: no-cache'
  ```
  - Response:
  ```json
    {
        "data": {
            "lat": -6.16,
            "lon": 106.73,
            "timezone": "Asia/Jakarta",
            "timezone_offset": 25200,
            "current": {
                "dt": 1602994982,
                "sunrise": 1602973827,
                "sunset": 1603017940,
                "temp": 31.56,
                "feels_like": 33.43,
                "pressure": 1009,
                "humidity": 55,
                "dew_point": 21.42,
                "uvi": 14.28,
                "clouds": 40,
                "visibility": 8000,
                "wind_speed": 3.6,
                "wind_deg": 50,
                "weather": [
                    {
                        "id": 802,
                        "main": "Clouds",
                        "description": "scattered clouds",
                        "icon": "03d"
                    }
                ]
            },
            "hourly": [
                {
                    "dt": 1602993600,
                    "temp": 31.56,
                    "feels_like": 34.08,
                    "pressure": 1009,
                    "humidity": 55,
                    "dew_point": 21.42,
                    "clouds": 40,
                    "visibility": 10000,
                    "wind_speed": 2.67,
                    "wind_deg": 13,
                    "weather": [
                        {
                            "id": 802,
                            "main": "Clouds",
                            "description": "scattered clouds",
                            "icon": "03d"
                        }
                    ],
                    "pop": 0.05
                },
                {
                    "dt": 1602997200,
                    "temp": 31.46,
                    "feels_like": 33.38,
                    "pressure": 1009,
                    "humidity": 54,
                    "dew_point": 21.03,
                    "clouds": 53,
                    "visibility": 10000,
                    "wind_speed": 3.24,
                    "wind_deg": 5,
                    "weather": [
                        {
                            "id": 803,
                            "main": "Clouds",
                            "description": "broken clouds",
                            "icon": "04d"
                        }
                    ],
                    "pop": 0.18
                },
            ]
        },
        "meta": {
            "version": "1",
            "hostname": "Komalas-MacBook-Pro.local",
            "client_ip": "127.0.0.1"
        }
    }
  ```

### Report
- Path: `/weathers/report`
- Method: `POST`
- Request Body:
  1. lat - user's latitude
  2. lon - user's longitude
  3. image
  4. temperature - between -25 and 100
- Heades:
  1. `Accept` = `application/json`
  2. `Content-Type` = `application/json`

## Account
### Login
- Path: `/auth`
- Method: `POST`
- Request Body:
  1. username
  2. password
- Heades:
  1. `Accept` = `application/json`
  2. `Content-Type` = `application/json`
- Response:
  1. signature
  2. expires_in - signature valid time countdown
 
  Sample:
  - Request:
  ```curl
  curl -X POST \
    http://localhost:8000/api/v1/auth \
    -H 'Accept: application/json' \
    -H 'Content-Type: application/json' \
    -H 'Postman-Token: 08490f1e-98f0-446f-8fa1-01c0de8ee1f0' \
    -H 'cache-control: no-cache' \
    -d '{
        "username":"komalasurya2",
        "password":"secret1"
    }'
  ```
  - Response:
  ```json
    {
        "data": {
            "expires_in": 3600,
            "signature": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJkNjY1M2NhMS05OGJlLTQwNjItODViZC01ZTRmNmVjMWRkMTkiLCJ1c2VybmFtZSI6ImtvbWFsYXN1cnlhMiIsImV4cCI6MTYwMjk5NzkwMX0.qsZNZ0Z5GWqVHzlKmTrrIrk8a7Ik2bBzMwDqzSZShKU9OBsI5B5gENn4_Xinh0Hq9NqZckSJYtd0M3cHfjtcLQ"
        },
        "meta": {
            "version": "1",
            "hostname": "Komalas-MacBook-Pro.local",
            "client_ip": "127.0.0.1"
        }
    }
  ```

### Register
- Path: `/users`
- Method: `POST`
- Request Body:
  1. username
  2. Email
  3. password
- Heades:
  1. `Accept` = `application/json`
  2. `Content-Type` = `application/json`    
 
  Sample:
  - Request:
  ```curl
  curl -X POST \
    http://localhost:8000/api/v1/users \
    -H 'Accept: application/json' \
    -H 'Content-Type: application/json' \
    -H 'Postman-Token: 752254c1-f355-4890-bc3f-695aa0549850' \
    -H 'cache-control: no-cache' \
    -d '{
        "username":"komalasurya2",
        "email": "komalasurya1@gmail.com",
        "password":"secret1"
    }'
  ```
  - Response:
  ```json
    {
        "data": {
            "username": "komalasurya",
            "email": "komalasurya@gmail.com",
            "password": "$2y$10$kRxB0N.xsW3OS/aRfV0DVuFVFdOpvBuBaKWZPJpcSnHxwLv1XCLXi",
            "id": "011b1ceb-30dd-4777-87c9-b41b204988f4",
            "updated_at": "2020-10-18 06:17:10",
            "created_at": "2020-10-18 06:17:10"
        },
        "meta": {
            "version": "1",
            "hostname": "Komalas-MacBook-Pro.local",
            "client_ip": "127.0.0.1"
        }
    }
  ```

  # Copyright
  Oneweather