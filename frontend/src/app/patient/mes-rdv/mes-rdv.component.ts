import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AppointmentService } from '../../services/appointment';

@Component({
  selector: 'app-mes-rdv',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './mes-rdv.component.html',
})
export class MesRdvComponent implements OnInit {
  rdvs: any[] = [];

  constructor(private apptService: AppointmentService) {}

  ngOnInit() {
    this.apptService.getAppointments().subscribe(data => this.rdvs = data);
  }
}