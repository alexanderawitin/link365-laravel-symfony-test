import { NgModule } from '@angular/core';
import { AuthService } from './auth.service';
import { AUTH_INTERCEPTORS } from './interceptors';

@NgModule({
    providers: [AuthService, ...AUTH_INTERCEPTORS],
})
export class AuthModule {}
