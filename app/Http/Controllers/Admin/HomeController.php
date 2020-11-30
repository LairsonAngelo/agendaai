<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
      $events = [];

      $appointments = \App\Appointment::with(['client', 'employee'])->get();

      foreach ($appointments as $appointment) {
          if (!$appointment->start_time) {
              continue;
          }
          if( isset($appointment->client->name) && isset($appointment->employee->name) ){
                $events[] = [
                    'title' => $appointment->client->name . ' ('.$appointment->employee->name.')',
                    'start' => $appointment->start_time,
                    'url'   => route('admin.appointments.edit', $appointment->id),
                ];
          }
      }

      return view('admin.calendar.calendar', compact('events'));
    }
}
