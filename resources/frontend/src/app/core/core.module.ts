import { NgModule } from '@angular/core';
import { AuthModule } from './auth';
import { NgxWebstorageModule } from 'ngx-webstorage';

@NgModule({
    imports: [NgxWebstorageModule.forRoot({ prefix: 'link365-laravel-symfony-test' }), AuthModule],
})
export class CoreModule {}
