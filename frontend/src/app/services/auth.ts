import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { inject } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class Auth {
  private http = inject(HttpClient);

  login(data: any) {
    return this.http.post('http://localhost:8000/api/login', data);
  }
}
