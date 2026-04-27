import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../services/auth';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [FormsModule, CommonModule, RouterLink],
  templateUrl: './register.component.html',
})
export class RegisterComponent {
  data  = { nom: '', email: '', password: '', password_confirmation: '', role: 'patient' };
  error = '';

  constructor(private auth: AuthService, private router: Router) {}

  onSubmit() {
    this.auth.register(this.data).subscribe({
      next: (res) => {
        if (res.user.role === 'medecin') {
          this.router.navigate(['/medecin/dashboard']);
        } else {
          this.router.navigate(['/patient/accueil']);
        }
      },
      error: (err) => this.error = err.error?.message || 'Erreur inscription',
    });
  }
}