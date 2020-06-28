import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HOME_COMPONENTS, HomeComponent } from './components';
import { SharedModule } from '../shared';
import { ForecastService } from './forecast.service';

export const routes: Routes = [
    {
        path: '',
        component: HomeComponent,
    },
];

@NgModule({
    imports: [SharedModule, RouterModule.forChild(routes)],
    declarations: [...HOME_COMPONENTS],
    exports: [...HOME_COMPONENTS],
    providers: [ForecastService],
})
export class HomeModule {}
