<?php

namespace App\Http\Livewire\Booking;

use App\Models\Booking;
use Livewire\Component;

class Create extends Component
{
    public Booking $booking;

    public function mount(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function render()
    {
        return view('livewire.booking.create');
    }

    public function submit()
    {
        $this->validate();

        $this->booking->save();

        return redirect()->route('admin.bookings.index');
    }

    protected function rules(): array
    {
        return [
            'booking.amount' => [
                'numeric',
                'required',
            ],
            'booking.date' => [
                'required',
                'date_format:' . config('project.datetime_format'),
            ],
        ];
    }
}
