import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { tap } from 'rxjs/operators';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private api = 'http://localhost:8000/api';

  constructor(private http: HttpClient, private router: Router) {}

  register(data: any) {
    return this.http.post<any>(`${this.api}/register`, data).pipe(
      tap(res => this.save(res))
    );
  }

  login(data: any) {
    return this.http.post<any>(`${this.api}/login`, data).pipe(
      tap(res => this.save(res))
    );
  }

  logout() {
    return this.http.post(`${this.api}/logout`, {}).pipe(
      tap(() => {
        localStorage.clear();
        this.router.navigate(['/auth/login']);
      })
    );
  }

  private save(res: any) {
    localStorage.setItem('token', res.token);
    localStorage.setItem('user', JSON.stringify(res.user));
  }

  getToken()  { return localStorage.getItem('token'); }
  getUser()   { const u = localStorage.getItem('user'); return u ? JSON.parse(u) : null; }
  isLoggedIn(){ return !!this.getToken(); }
  isMedecin() { return this.getUser()?.role === 'medecin'; }
  isPatient() { return this.getUser()?.role === 'patient'; }
}