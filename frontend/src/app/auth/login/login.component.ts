import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../services/auth';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './login.component.html',
})
export class LoginComponent {
  data  = { email: '', password: '' };
  error = '';

  constructor(private auth: AuthService, private router: Router) {}

  onSubmit() {
    this.auth.login(this.data).subscribe({
      next: (res) => {
        if (res.user.role === 'medecin') {
          this.router.navigate(['/medecin/dashboard']);
        } else {
          this.router.navigate(['/patient/accueil']);
        }
      },
      error: () => this.error = 'Email ou mot de passe incorrect',
    });
  }
}