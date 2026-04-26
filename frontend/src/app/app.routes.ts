import { Routes } from '@angular/router';
import { AuthGuard, MedecinGuard } from './guards/auth.guard';

export const routes: Routes = [
  { path: '', redirectTo: 'auth/login', pathMatch: 'full' },
  
  { path: 'auth/login', 
    loadComponent: () => import('./auth/login/login.component')
    .then(m => m.LoginComponent) },
  
  { path: 'auth/register', 
    loadComponent: () => import('./auth/register/register.component')
    .then(m => m.RegisterComponent) },
  
  { path: 'patient/accueil', 
    canActivate: [AuthGuard], 
    loadComponent: () => import('./patient/accueil/accueil.component')
    .then(m => m.AccueilComponent) },
  
  { path: 'patient/mes-rdv', 
    canActivate: [AuthGuard], 
    loadComponent: () => import('./patient/mes-rdv/mes-rdv.component')
    .then(m => m.MesRdvComponent) },
  
  { path: 'medecin/dashboard', 
    canActivate: [AuthGuard, MedecinGuard], 
    loadComponent: () => import('./medecin/dashboard/dashboard.component')
    .then(m => m.DashboardComponent) },
];