
@props(['students','inputs'])


<form wire:submit.prevent='store("librarian")'>
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

        <div class="form-group  ">
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
                        <option class=" bg-white text-secondary " value="telephone">
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
        </div>
        <div class="form-group  ">
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
    </div>
</form>