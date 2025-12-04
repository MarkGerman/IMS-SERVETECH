@php
    use Illuminate\Support\Facades\Auth;
@endphp
<div>
    {{-- dev by Techlink360 --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            {{-- dev by Techlink360: Show all users --}}
            @if ($folder == 'all')
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-12 col-lg-12">
                        <div class="d-flex justify-content-end">
                            <div class="form-group pr-1">
                                {{-- dev by Techlink360: Search input --}}
                                <input wire:model.live="search" type="search" placeholder="search"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                {{-- dev by Techlink360: Button to show create user form --}}
                                <button class="btn btn-primary form-control" wire:click='create'>
                                    <span wire:loading wire:target="create" class="spinner-border spinner-border-sm"
                                        role="status" aria-hidden="true"></span>
                                    add
                                </button>
                            </div>

                        </div>
                        <div class="card ">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm table-inverse  ">
                                        <thead class="thead-inverse">
                                            <tr class="">
                                                <th></th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($u as $item)
                                                @if ($item->role != 'system')
                                                    <tr>
                                                        <td scope="row"><img
                                                                src="@if ($item->profile_photo_path == '') {{ asset('assets/uploads/images/face-0.jpg') }}  @else{{ asset('storage/' . $item->profile_photo_path) }} @endif"
                                                                class="rounded" height="30" width="30"
                                                                alt="">
                                                        </td>

                                                        <td>{{ $item->name }}</td>
                                                        <td> {{ $item->email }}</td>
                                                        <td>
                                                            {{ $item->role }}
                                                        </td>
                                                        <td><span
                                                                class=" h6 text-white @if ($item->status == true) badge bg-success  @else badge bg-danger @endif">
                                                                @if ($item->status == true)
                                                                    Active
                                                                @else
                                                                    Inactive
                                                                @endif
                                                            </span></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button"
                                                                    class="btn btn-info btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    {{-- dev by Techlink360: Button to show edit user form --}}
                                                                    <a class="dropdown-item"
                                                                        wire:click="edit({{ $item->id }})"
                                                                        href="#">Edit</a>
                                                                    {{-- dev by Techlink360: Button to delete user --}}
                                                                    <a class="dropdown-item"
                                                                        wire:click="delete({{ $item->id }})"
                                                                        wire:confirm="Are you sure you want to delete this user?"
                                                                        href="#">Delete</a>

                                                                    @if ($item->status == true)
                                                                        {{-- dev by Techlink360: Button to deactivate user --}}
                                                                        <a class="dropdown-item"
                                                                            wire:click="deactivate({{ $item->id }})"
                                                                            href="#">Deactivate</a>
                                                                    @else
                                                                        {{-- dev by Techlink360: Button to activate user --}}
                                                                        <a class="dropdown-item"
                                                                            wire:click="activate({{ $item->id }})"
                                                                            href="#">Activate</a>
                                                                    @endif
                                                                </div>

                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted h1">EMPTY</td>

                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                        {{ $u->links() }}

                    </div>
                    <!-- Column -->

                </div>
            @endif
            {{-- dev by Techlink360: Show edit user form --}}
            @if ($folder == 'edit')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-end">

                            <div class="form-group">
                                <div class="btn-group">
                                    {{-- dev by Techlink360: Button to cancel editing and return to all users view --}}
                                    <button class="btn btn-sm btn-primary form-control" wire:click='cancel'>
                                        <span wire:loading wire:target="cancel"
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Cancel
                                    </button>


                                </div>
                            </div>

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="h3">Edit</div>
                                <form wire:submit.prevent='update'>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <div class="text-center">
                                                <div class="col-12">
                                                    {{-- dev by Techlink360: User profile photo --}}
                                                    <img src="@if ($user->profile_photo_path == null) {{ asset('assets/uploads/images/face-0.jpg') }}  @else{{ asset('storage/' . $user->profile_photo_path) }} @endif"
                                                        alt="" class="rounded" height="50"
                                                        width="50" srcset="">
                                                    <div class="d-flex">
                                                        <div x-data="{ isUploading: false, progress: 0 }"
                                                            x-on:livewire-upload-start="isUploading = true"
                                                            x-on:livewire-upload-finish="isUploading = false"
                                                            x-on:livewire-upload-error="isUploading = false"
                                                            x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                            class="pr-1">
                                                            {{-- dev by Techlink360: Input to upload new profile photo --}}
                                                            <input wire:model.defer="photo" type="file"
                                                                class="form-control @error('photo') is-invalid @enderror">
                                                            <div x-show="isUploading">
                                                                <progress max="100"
                                                                    x-bind:value="progress"></progress>
                                                            </div>
                                                            @error('photo')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="pl-1">
                                                            @if (!$user->profile_photo_path == '')
                                                                {{-- dev by Techlink360: Button to remove profile photo --}}
                                                                <button wire:click='removeimage'
                                                                    class="btn btn-sm btn-danger">remove</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Full Name</label>
                                            <input type="text" wire:model.defer="name"
                                                class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Email</label>
                                            <input type="email" wire:model.defer="email"
                                                class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Role</label>

                                            <select type="text" wire:model.defer="role"
                                                class="form-control @error('role') is-invalid @enderror">
                                                <option value="">Select role</option>
                                                @foreach ($this->allRoles as $availableRole)
                                                    @if ($availableRole == 'system' && Auth::user()->role != 'system')
                                                        @continue
                                                    @endif
                                                    <option value="{{ $availableRole }}">
                                                        {{ ucfirst($availableRole) }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Gender</label>
                                            <select type="text" wire:model.defer="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Status</label>
                                            <select type="text" wire:model.defer="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{-- dev by Techlink360: Button to update user --}}
                                        <button type="submit" class="btn btn-dark">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- dev by Techlink360: Show create user form --}}
            @if ($folder == 'create')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="h3">Add New User</div>

                                    <div class="form-group">
                                        <div class="btn-group">
                                            {{-- dev by Techlink360: Button to cancel creating and return to all users view --}}
                                            <button class="btn btn-sm btn-primary form-control"
                                                wire:click='cancel'>
                                                <span wire:loading wire:target="cancel"
                                                    class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Back
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <form wire:submit.prevent='store()'>
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Full Name</label>
                                            <input type="text" wire:model.defer="name"
                                                class="form-control @error('name') is-invalid @enderror">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Email</label>
                                            <input type="email" wire:model.defer="email"
                                                class="form-control @error('email') is-invalid @enderror">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Role</label>
                                            <select type="text" wire:model.live="role"
                                                class="form-control @error('role') is-invalid @enderror">
                                                <option value="">Select role</option>
                                                @foreach ($this->allRoles as $availableRole)
                                                    @if ($availableRole == 'system' && Auth::user()->role != 'system')
                                                        @continue
                                                    @endif
                                                    <option value="{{ $availableRole }}">
                                                        {{ ucfirst($availableRole) }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
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
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Status</label>
                                            <select type="text" wire:model.defer="status"
                                                class="form-control @error('status') is-invalid @enderror">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-6">
                                            <label for="">Password</label>
                                            <input type="text" readonly wire:model.defer="password"
                                                class="form-control @error('password') is-invalid @enderror">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{-- dev by Techlink360: Button to save new user --}}
                                        <button type="submit" class="btn btn-dark">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


    </section>

</div>

