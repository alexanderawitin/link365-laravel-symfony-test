import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable()
export class ForecastService {
    endpoint = 'https://api.openweathermap.org/data/2.5';
    apiParams = { appid: '903559387aa25d760c362b507942a1a2', lang: 'en_US', units: 'metric' };

    constructor(private http: HttpClient) {}

    getWeatherData(city: string): Observable<any> {
        return this.http.get(`/api/data`, { params: { city } });
    }

    getWeatherForecast(city: string): Observable<any> {
        return this.http.get(`${this.endpoint}/forecast`, { params: { ...this.apiParams, q: city } });
    }
}
