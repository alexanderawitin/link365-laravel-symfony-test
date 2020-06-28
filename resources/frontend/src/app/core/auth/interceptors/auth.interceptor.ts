import { Observable } from 'rxjs';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { switchMap } from 'rxjs/operators';
import { AuthService } from '../auth.service';
import { Inject } from '@angular/core';
import { ApiUrlToken } from '../../tokens';

export class AuthInterceptor implements HttpInterceptor {
    constructor(private authService: AuthService, @Inject(ApiUrlToken) private apiUrl: string) {}

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        if (!request || !request.url || (/^http/.test(request.url) && !(this.apiUrl && request.url.startsWith(this.apiUrl)))) {
            return next.handle(request);
        }

        return this.authService.getAuthToken().pipe(
            switchMap(token => {
                if (token) {
                    request = request.clone({
                        setHeaders: {
                            Authorization: 'Bearer ' + token,
                        },
                    });
                }
                return next.handle(request);
            }),
        );
    }
}
