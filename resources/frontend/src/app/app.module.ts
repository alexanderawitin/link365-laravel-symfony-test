import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ApiUrlToken, CoreModule, PassportClientId, PassportClientSecret } from './core';
import { environment } from '../environments/environment';

@NgModule({
    declarations: [AppComponent],
    imports: [BrowserModule, AppRoutingModule, CoreModule],
    providers: [
        {
            provide: ApiUrlToken,
            useValue: environment.apiUrl,
        },
        {
            provide: PassportClientId,
            useValue: environment.passportClientId,
        },
        {
            provide: PassportClientSecret,
            useValue: environment.passportClientSecret,
        },
    ],
    bootstrap: [AppComponent],
})
export class AppModule {}
