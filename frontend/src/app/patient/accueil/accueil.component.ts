import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SlotService } from '../../services/slot.service';
import { AppointmentService } from '../../services/appointment.service';

@Component({
  selector: 'app-accueil',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './accueil.component.html',
})
export class AccueilComponent implements OnInit {
  slots: any[] = [];
  message      = '';

  constructor(private slotService: SlotService, private apptService: AppointmentService) {}

  ngOnInit() {
    this.slotService.getSlots().subscribe(data => this.slots = data);
  }

  reserver(creneauId: number) {
    this.apptService.book(creneauId).subscribe({
      next: () => {
        this.message = 'Rendez-vous réservé !';
        this.slots   = this.slots.filter(s => s.id !== creneauId);
      },
      error: (err) => this.message = err.error?.message || 'Erreur réservation',
    });
  }
}