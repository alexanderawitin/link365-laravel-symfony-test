import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LocalStorageService } from 'ngx-webstorage';
import { FaIconLibrary } from '@fortawesome/angular-fontawesome';
import { faCog } from '@fortawesome/free-solid-svg-icons/faCog';
import { ForecastService } from '../../forecast.service';
import { IWeatherData } from '../../../../core/models';

@Component({
    selector: 'app-home',
    templateUrl: 'home.component.html',
    styleUrls: ['./home.component.scss'],
    encapsulation: ViewEncapsulation.None,
})
export class HomeComponent implements OnInit {
    cityName: string = 'Banilad, Mandaue, Philippines';
    weatherData: IWeatherData;

    modal = false;

    constructor(
        private http: HttpClient,
        private localStorage: LocalStorageService,
        private iconLib: FaIconLibrary,
        private forecastService: ForecastService,
    ) {
        iconLib.addIcons(faCog);
    }

    ngOnInit() {
        this.setCities();
        this.getWeather();
    }

    setCities() {
        if (this.localStorage.retrieve('cityName')) {
            this.cityName = this.localStorage.retrieve('cityName');
        } else {
            this.localStorage.store('cityName', this.cityName);
        }
    }

    getWeather() {
        this.forecastService.getWeatherData(this.cityName).subscribe(city => (this.weatherData = city));
    }

    changeCities() {
        this.modal = true;
    }

    closeModal() {
        this.modal = false;
        this.localStorage.store('cityName', this.cityName);
        this.getWeather();
    }
}
