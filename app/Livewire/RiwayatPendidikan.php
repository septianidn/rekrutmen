<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title('Riwayat Pendidikan')]
#[Layout('frontoffice.jobseeker.profile')]
class RiwayatPendidikan extends Component
{
    public function render()
    { 
        $job = 'jobless';
        return view('frontoffice.jobseeker.livewire.riwayat-pendidikan')->title('Profile');
    }
}
