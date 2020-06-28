import { Inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { LocalStorageService } from 'ngx-webstorage';
import { ApiUrlToken, PassportClientId, PassportClientSecret } from '../tokens';
import { Observable, of } from 'rxjs';
import { tap } from 'rxjs/operators';

@Injectable()
export class AuthService {
    accessTokenKey = 'access_token';

    constructor(
        private http: HttpClient,
        private localStorage: LocalStorageService,
        @Inject(ApiUrlToken)
        private apiUrl: string,
        @Inject(PassportClientId)
        private passportClientId: string,
        @Inject(PassportClientSecret)
        private passportClientSecret: string,
    ) {}

    /**
     * Retrieve the access token from local storage
     */
    getAuthToken(): Observable<string> {
        return of(this.localStorage.retrieve(this.accessTokenKey));
    }

    /**
     * Request an access token from the API
     */
    login(username: string, password: string) {
        return this.http
            .post('/oauth/token', {
                grant_type: 'password',
                client_id: this.passportClientId,
                client_secret: this.passportClientSecret,
                username,
                password,
                scope: '',
            })
            .pipe(tap(next => console.log('login: next', next)));
    }

    register(name: string, email: string, password: string) {}

    /**
     * Revoke the authenticated user's token
     */
    logout() {
        return this.http.delete('/oauth/token/{tokenid}').pipe(tap(() => this.localStorage.clear(this.accessTokenKey)));
    }
}
