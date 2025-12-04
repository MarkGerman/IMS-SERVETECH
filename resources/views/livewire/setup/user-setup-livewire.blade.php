<div class="container mt-5">

    <!-- Loader Section -->
    <div wire:loading>
        <div class="d-flex justify-content-center mb-4">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;"></div>
        </div>
        <h4 class="text-center">Checking system setup...</h4>
    </div>

    <div wire:loading.remove>

        <!-- Title -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="text-center">System Setup</h3>
                <p class="text-center text-muted">We are verifying your installation…</p>
            </div>
        </div>

        <!-- Results -->
        <div class="row">

            <!-- DB Connection -->
            <div class="col-md-4 mb-3">
                <div class="card border-left-primary shadow-sm p-3">
                    <h5>Database Connection</h5>

                    @if($dbConnected)
                        <span class="badge bg-success">Connected</span>
                    @else
                        <span class="badge bg-danger">Failed</span>
                        <p class="text-danger mt-2">Unable to connect to database.</p>
                    @endif
                </div>
            </div>

            <!-- Users Table -->
            <div class="col-md-4 mb-3">
                <div class="card border-left-warning shadow-sm p-3">
                    <h5>Users Table</h5>

                    @if($usersTableExists)
                        <span class="badge bg-success">Exists</span>
                    @else
                        <span class="badge bg-danger">Not Found</span>
                        <p class="text-danger mt-2">Run migrations to create required tables.</p>
                    @endif

                </div>
            </div>

            <!-- Owner Check -->
            <div class="col-md-4 mb-3">
                <div class="card border-left-info shadow-sm p-3">
                    <h5>Owner Account</h5>

                    @if($hasOwner)
                        <span class="badge bg-success">Owner Found</span>
                        <p class="text-muted mt-2">System is ready.</p>
                    @else
                        <span class="badge bg-danger">Owner Missing</span>
                        <p class="text-danger mt-2">You must create an owner account.</p>

                        <a href="#" wire:click.prevent='open' class="btn btn-primary btn-sm mt-2">
                            Create Owner Account
                        </a>
                    @endif

                @if ($form)
                        <form wire:submit.prevent='store'>

                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text"  wire:model="name" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" wire:model="email" class="form-control">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" wire:model="password" class="form-control">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Create Owner Account <x-spinner for="store" />  </button>




                    </form>
                @endif





                </div>
            </div>

        </div>

        <!-- Re-check Button -->
        <div class="text-center mt-4">
            <button wire:click="runChecks" class="btn btn-secondary">
                <i class="fas fa-sync-alt"></i> Re-run Setup Check
            </button>
            <a href="{{ route('login') }}" class="btn btn-success" >Skip to Login <i class="fas fa-sign-in-alt" ></i> </a>
        </div>


    </div>
</div>
