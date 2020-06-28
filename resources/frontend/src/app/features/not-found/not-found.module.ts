import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { ACCESS_DENIED_COMPONENTS, NotFoundComponent } from './components';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
    {
        path: '',
        component: NotFoundComponent,
    },
];

@NgModule({
    imports: [SharedModule, RouterModule.forChild(routes)],
    declarations: [...ACCESS_DENIED_COMPONENTS],
    exports: [...ACCESS_DENIED_COMPONENTS],
})
export class NotFoundModule {}
