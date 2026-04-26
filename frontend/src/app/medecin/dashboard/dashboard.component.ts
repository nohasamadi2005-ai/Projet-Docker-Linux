import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { SlotService } from '../../services/slot';
import { AppointmentService } from '../../services/appointment';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './dashboard.component.html',
})
export class DashboardComponent implements OnInit {
  slots: any[]  = [];
  rdvs: any[]   = [];
  message       = '';
  newSlot = { date_creneau: '', heure_debut: '', heure_fin: '' };

  constructor(private slotService: SlotService, private apptService: AppointmentService) {}

  ngOnInit() {
    this.slotService.getSlots().subscribe(data => this.slots = data);
    this.apptService.getAppointments().subscribe(data => this.rdvs = data);
  }

  ajouterSlot() {
    this.slotService.createSlot(this.newSlot).subscribe({
      next: (slot: any) => {
        this.slots.push(slot);
        this.message = 'Créneau ajouté !';
        this.newSlot = { date_creneau: '', heure_debut: '', heure_fin: '' };
      },
      error: () => this.message = 'Erreur ajout créneau',
    });
  }

  supprimerSlot(id: number) {
    this.slotService.deleteSlot(id).subscribe({
      next: () => this.slots = this.slots.filter(s => s.id !== id),
      error: () => this.message = 'Erreur suppression',
    });
  }

  changerStatut(id: number, statut: string) {
    this.apptService.updateStatus(id, statut).subscribe({
      next: () => this.apptService.getAppointments().subscribe(data => this.rdvs = data),
      error: () => this.message = 'Erreur mise à jour',
    });
  }
}