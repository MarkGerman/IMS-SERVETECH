@props(['students', 'inputs', 'numbers', 'mobile_number_modal','mobile_number_modal_title','levels'])
<form wire:submit.prevent='store("student")'>
    <div class="row">
        <div class=" col-lg-12 ">

            <div class="form-group col-sm-12 ">
                <label for="">Full Name</label>
                <input type="text" wire:model.defer="Name" class="form-control @error('Name') is-invalid @enderror">
                @error('Name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-sm-12 ">
                <label for="">Email</label>
                <input type="email" wire:model.defer="email"
                    class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-sm-12 ">
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
            <div class="form-group col-sm-12 ">
                <label for="">Date of birth</label>
                <input type="date" wire:model.defer="date_of_birth"
                    class="form-control @error('date_of_birth') is-invalid @enderror">
                @error('date_of_birth')
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


            {{-- <div class="form-group ">
                <label for="">Phone Number</label>
                @foreach ($inputs as $key => $item)
                    <div class="input-group pt-1">
                        <select type="text"
                            wire:model.defer="inputs.{{ $key }}.phone_type"
                            class="col-lg-4 bg-secondary form-control text-white @error('inputs.' . $key . '.phone_type') is-invalid @enderror">
                            <option value="">select type</option>
                            <option class="bg-white text-success" value="whatsapp"> <i
                                    class="fab fa-whatsapp  "></i> Whatsapp
                            </option>
                            <option class=" bg-white text-secondary  " value="cell">
                                Cell
                            </option>
                            <option class=" bg-white text-secondary "
                                value="telephone">
                                Telephone</option>
                        </select>
                        <input type="text"
                            wire:model.defer="inputs.{{ $key }}.phone"
                            placeholder="265..."
                            class="form-control @error('inputs.' . $key . '.phone') is-invalid @enderror"">

                        <div class="d-flex justify-between">

                            <div class="px-1">
                                @if ($key > 0)
                                    <button
                                        wire:click.prevent="removeno({{ $key }})"
                                        class="btn btn-sm btn-success"><i
                                            class="fa fa-minus"
                                            aria-hidden="true"></i></button>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        @error('inputs.' . $key . '.phone_type')
                            <span class="col-lg-4 text-danger">{{ $message }}</span>
                        @enderror
                        @error('inputs.' . $key . '.phone')
                            <span class="col-lg-8 text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <div class="text-center">
                    <button wire:click.prevent="addno" class="btn btn-link"><i
                            class="fa fa-plus" aria-hidden="true"></i> add phone
                        number</button>
                </div>
            </div> --}}

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
        </div>
    </div>
    <div class="form-group">
        <label for="">Medical Issues</label>
        <textarea wire:model.defer="medical_issues" class=" form-control @error('medical_issues') is-invalid @enderror "></textarea>
        @error('medical_issues')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
    <div class="form-group">
        <button type="submit" class="btn btn-dark">Save
            <span wire:target='store' wire:loading  class="spinner-border spinner-border-sm"></span>
        </button>
    </div>
</form>



