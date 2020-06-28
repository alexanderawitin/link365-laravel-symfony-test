import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { AuthInterceptor } from './auth.interceptor';
import { AuthService } from '../auth.service';
import { ApiUrlToken } from '../../tokens';

export * from './auth.interceptor';

export const AUTH_INTERCEPTORS = [
    {
        provide: HTTP_INTERCEPTORS,
        useClass: AuthInterceptor,
        deps: [AuthService, ApiUrlToken],
        multi: true,
    },
];
