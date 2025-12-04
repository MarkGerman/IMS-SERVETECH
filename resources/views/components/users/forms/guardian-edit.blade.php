<!-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius -->
@props(['students', 'inputs','numbers','children'])


<form wire:submit.prevent='store("guardian")'>
    <div class="row">
        <div class="form-group col-sm-12 ">
            <label for="">Full Name</label>
            <input type="text" wire:model.defer="Name" class="form-control @error('Name') is-invalid @enderror">
            @error('Name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-sm-12 ">
            <label for="">Email</label>
            <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group col-sm-12 ">
            <label for="">Guardian Role</label>
            <select class="form-control @error('guardian_role') is-invalid @enderror" wire:model.defer="guardian_role">
                <option value="">select</option>
                <option value="mother">Mother</option>
                <option value="father">Father</option>
                <option value="brother">Brother</option>
                <option value="sister">Sister</option>
                <option value="uncle">Uncle</option>
                <option value="aunt">Aunt</option>
                <option value="cousin">Cousin</option>
                <option value="granmother">Granmother</option>
                <option value="granfather">Granfather</option>
            </select>
            @error('guardian_role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        

        <div class="form-group col-12 col-lg-4">

            <label class="text-center" for="">Guardian Children</label>

            @forelse ($children as $item)
                <div class="d-flex justify-content-center py-2">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-user-circle fa-2x text-primary" aria-hidden="true"></i>
                        {{-- @if ($item->phone_type == 'whatsapp')
                            <i class="fab fa-2x fa-whatsapp text-success " aria-hidden="true"></i>
                        @else
                            <i class="fa fa-phone text-primary" aria-hidden="true"></i>
                        @endif --}}
                        <span class=" font-18 px-2 text-capitalize "> {{ $item->student->name }}</span> <i class="fa fa-arrow-left text-success" aria-hidden="true"></i>  <span class="text-primary font-18 px-2 text-capitalize" >{{ $item->guardian_role }}</span>

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
                <button class="btn btn-link" wire:click.prevent='open_child_modal' > <i class="fa fa-plus" aria-hidden="true"></i> Add child</button>
            </div>

        </div>
        <div class="form-group col-12  col-lg-4">
            <label class="text-center" for="">Nationality</label>

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


        <div class="form-group col-12 col-lg-4 ">

            <label class="text-center" for="">Mobile Numbers</label>

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

        <div class="form-group col-sm-12 ">
            <label for="">Address</label>
            <textarea type="text" wire:model.defer="address" class="form-control @error('address') is-invalid @enderror"></textarea>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-sm-12 ">
            <label for="">Occupation</label>
            <input type="text" wire:model.defer="occupation"
                class="form-control @error('occupation') is-invalid @enderror">
            @error('occupation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group ">
        <label for="">Password</label>
        <input type="text" readonly wire:model.defer="password"
            class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-dark">Store</button>
    </div>
</form>
