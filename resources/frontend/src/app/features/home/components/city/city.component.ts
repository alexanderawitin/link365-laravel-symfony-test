import { Component, Input, NgZone, OnInit, ViewEncapsulation } from '@angular/core';
import { faCloudShowersHeavy, faCloudSun, faSnowflake, faSun } from '@fortawesome/free-solid-svg-icons';
import { FaIconLibrary } from '@fortawesome/angular-fontawesome';
import { ForecastService } from '../../forecast.service';
import { IWeatherData } from '../../../../core/models';

@Component({
    selector: 'app-city',
    templateUrl: './city.component.html',
    styleUrls: ['./city.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class CityComponent implements OnInit {
    api = '730a4f921d9336f2c6284ae5cadcba88';

    @Input() weatherData: IWeatherData;

    forecast;
    fiveDay = [];
    link;

    constructor(private zone: NgZone, private iconLib: FaIconLibrary, private forecastService: ForecastService) {
        iconLib.addIcons(faCloudShowersHeavy, faCloudSun, faSnowflake, faSun);
    }

    ngOnInit(): void {
        this.forecastService.getWeatherForecast(this.weatherData.resolved_city).subscribe(forecast => {
            this.fiveDay = [];
            this.forecast = forecast;

            if (this.forecast.list) {
                let i;
                for (i = 7; i < this.forecast.list.length; i = i + 8) {
                    this.fiveDay.push(this.forecast.list[i]);
                }
            }
        });
    }

    convert(temp) {
        return temp;
        // return Math.round((kelvin - 273) * 1.8 + 32);
    }

    changeDesc(desc) {
        if (desc === 'Clouds') {
            return 'Cloudy';
        } else if (desc === 'Smoke') {
            return 'Smokey';
        } else if (desc === 'Rain') {
            return 'Raining';
        } else if (desc === 'Snow') {
            return 'Snowing';
        } else {
            return desc;
        }
    }

    calcHsl(num) {
        // const newNum = Math.round(num);
        // if (newNum > 287) {
        //     return Math.abs(newNum - 320);
        // } else {
        //     const percent = (1 / 60) * newNum;
        //     return Math.round(percent * 50);
        // }
        return Math.round(num + 273.15);
    }

    windDirection(degree) {
        const val = Math.floor(degree / 22.5 + 0.5);
        const arr = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
        return arr[val % 16];
    }

    round(num) {
        return Math.round(num);
    }

    getTime(epoch) {
        const d = new Date(0);
        d.setUTCSeconds(epoch);
        let hours = d.getHours();
        const minutes = this.minutes_with_leading_zeros(d);
        if (hours > 12) {
            hours = hours - 12;
        }
        return hours + ':' + minutes;
    }

    minutes_with_leading_zeros(dt) {
        return (dt.getMinutes() < 10 ? '0' : '') + dt.getMinutes();
    }

    convertDay(day) {
        const newDay = day.dt_txt.replace(' ', 'T');
        const d = new Date(newDay);
        const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
        return days[d.getDay()];
    }

    getIcon(name) {
        if (name === 'Clear') {
            return 'sun';
        } else if (name === 'Clouds') {
            return 'cloud-sun';
        } else if (name === 'Rain') {
            return 'cloud-showers-heavy';
        } else if (name === 'Snow') {
            return 'snowflake';
        }
    }
}
