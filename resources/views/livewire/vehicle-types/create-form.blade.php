<?php
use App\Repositories\VehicleTypesRepository;
use function Livewire\Volt\{state,usesFileUploads,rules,updated};

state([
    'name' => '',
    'fare' => '',
    'upload' => null
]);

usesFileUploads();

$save = function(){
    $validated = $this->validate([
        'name' => ['required', 'regex:/^[\pL\s]+$/u', 'string', 'min:2', 'max:50'],
        'fare' => ['required', 'decimal:2'],
        'upload' => ['required', 'file']

    ]);
    $validated += [
            'upload_url' => $this->upload->store('drivers')
        ];

    VehicleTypesRepository::create($validated);

    session()->flash('success','Type has been created');
    $this->redirect(url()->previous());
}?>

<div>
    <div class="col-8 h-[664px] bg-stone-50 rounded-[20px] border border-stone-300 p-4 ml-5">
        <x-auth-session-status class="mb-4" :status="session('success')" />
        <form wire:submit="save"  class="mt-4">
            <div class="text-xl font-bold tracking-tight text-black">Type Details</div>
            <div class="mt-4 form-row">
                <x-form-input :errorMessage="$errors->get('name')"  type="text" placeholder="Name" name="name" wire:model="name"/>
                <x-form-input :errorMessage="$errors->get('fare')"  type="text" placeholder="Base Fare" name="fare" wire:model="fare"/>
            </div>
            <div class="mt-4 form-row">
                <div class="mb-3 col-md-6">
                    <div class="form-group">
                        <input type="file" class="form-control"  placeholder="Type Image" wire:model="upload">
                        <x-input-error :messages="$errors->get('upload')" class="mt-2" />
                    </div>
                </div>
            </div>
            <x-primary-button>
                {{__('Continue')}}
            </x-primary-button>
      </form>
    </div>
</div>
