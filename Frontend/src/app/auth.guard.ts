import { Injectable } from '@angular/core';
import {
  Router,
  CanActivate,
  RouterStateSnapshot,
  ActivatedRouteSnapshot,
} from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard implements CanActivate {
  constructor(private router: Router) {
    //
  }
  token: any;
  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): any {
    this.token = localStorage.getItem('token');
    console.log(this.token);
    
    if (this.token) return true;
    else this.router.navigate(['login']);
  }
}
