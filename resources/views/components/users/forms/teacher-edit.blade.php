@props(['students','inputs','subjects','levels','numbers'])


<form wire:submit.prevent='store("teacher")'>
    <div class="">
        <div class="form-group ">
            <label for="">Full Name</label>
            <input type="text" wire:model.defer="Name"
                class="form-control @error('Name') is-invalid @enderror">
            @error('Name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group ">
            <label for="">Gender</label>
            <select type="text" wire:model.defer="gender"
                class="form-control @error('gender') is-invalid @enderror">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @error('gender')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group ">
            <label for="">Email</label>
            <input type="email" wire:model.defer="email"
                class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group  ">
            <label for="">Nationality</label>

            <select wire:model.defer='nationality'
            class="form-control @error('nationality') is-invalid @enderror">
                <option value="">Select country</option>
                @forelse ( Country::all() as $item )
                    <option value="{{ $item }}">{{ $item }}</option>
                @empty
                <option value="">EMPTY</option>
                    
                @endforelse
               
            </select>
            @error('nationality')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Subject</label>
            <select wire:model.defer='level' class="form-control" >
                <option value="">Select Level</option>
                @forelse ($levels as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @empty
                    <option value="">Empty</option>
                @endforelse
                
            </select>
            <x-error for="level" />
               
        </div>
        <div class="form-group">
            <label for="">Subject</label>
            <select wire:model.defer='subject' class="form-control" >
                <option value="">Select Subject</option>
                <option value="0">All</option>
                @forelse ($subjects as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @empty
                    <option value="">Empty</option>
                @endforelse
                
            </select>
            <x-error for="subject" />
               
        </div>

        
        <div class="form-group">

            <label for="">Mobile Numbers</label>

            @forelse ($numbers as $item)
                <div class="d-flex justify-content-center py-2">
                    <div class="d-flex align-items-center">
                        @if ($item->phone_type == 'whatsapp')
                            <i class="fab fa-2x fa-whatsapp text-success " aria-hidden="true"></i>
                        @else
                            <i class="fa fa-phone text-primary" aria-hidden="true"></i>
                        @endif
                        <span class="text-primary font-18 px-2 "> +{{ $item->number }}</span>

                    </div>
                    <button title="Remove Mobile" wire:click.prevent='confirm_delete({{ $item->id }})' class=" btn btn-sm btn-success">
                        <i class="fa fa-minus" aria-hidden="true"></i> 
                            <span class="spinner-border spinner-border-sm" wire:loading wire:target='confirm_delete({{ $item->id }})'  ></span> 
                        </button>
                </div>


            @empty
                <div class="d-flex justify-content-center ">
                    <div class="text-center">
                        EMPTY
                    </div>
                </div>
            @endforelse
            <div class="d-flex justify-content-center">
                <button class="btn btn-link" wire:click.prevent='open_number_modal' > <i class="fa fa-plus" aria-hidden="true"></i> Add Mobile</button>
            </div>

        </div>



       

        <div class="form-group">
            <button type="submit" class="btn btn-dark">Store</button>
        </div>
    </div>
</form>