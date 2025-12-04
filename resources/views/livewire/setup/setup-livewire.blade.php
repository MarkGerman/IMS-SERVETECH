<div class="container">
    <div class="content-header">
        <h1 class="m-0">System Settings</h1>
    </div>

    <div class="content">
        <div class="container-fluid">

            <form wire:submit.prevent="saveSettings">

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">System Information</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>System Organization Name</label>
                            <input type="text" class="form-control" wire:model="system_organization_name">
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <label>Phone 1</label>
                                <input type="text" class="form-control" wire:model="system_phone_1">
                            </div>

                            <div class="col-md-4">
                                <label>Phone 2</label>
                                <input type="text" class="form-control" wire:model="system_phone_2">
                            </div>

                            <div class="col-md-4">
                                <label>Phone 3</label>
                                <input type="text" class="form-control" wire:model="system_phone_3">
                            </div>

                        </div>

                        <div class="form-group mt-3">
                            <label>System Logo</label><br>
                            <input type="file" class="form-control-file" wire:model="logo">
                            @if ($logo)
                                <img src="{{ is_string($logo) ? asset('storage/'.$logo) : $logo->temporaryUrl() }}"
                                     alt="Logo" class="img-thumbnail mt-2" width="120">
                            @endif
                        </div>

                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="card-title">Shop Information</h4>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" wire:model="shop_name">
                        </div>

                        <div class="form-group">
                            <label>Shop Email</label>
                            <input type="email" class="form-control" wire:model="shop_email">
                        </div>

                        <div class="form-group">
                            <label>Shop Phone</label>
                            <input type="text" class="form-control" wire:model="shop_phone">
                        </div>

                        <div class="form-group">
                            <label>Shop Address</label>
                            <textarea class="form-control" wire:model="shop_address"></textarea>
                        </div>

                    </div>
                </div>


                <div class="card mt-4">
                    <div class="card-header bg-warning">
                        <h4 class="card-title">Business Settings</h4>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">
                                <label>Markup Percentage (%)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="markup_percentage">
                                <small class="text-muted">Example: 15 = 15% markup</small>
                            </div>

                            <div class="col-md-6">
                                <label>Tax Percentage (%)</label>
                                <input type="number" step="0.01" class="form-control" wire:model="tax_percentage">
                            </div>

                        </div>

                        <div class="mt-3">
                            <label>POS Enabled</label>
                            <select class="form-control" wire:model="pos_enabled">
                                <option value="1">Enabled</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label>Allow Negative Stock</label>
                            <select class="form-control" wire:model="allow_negative_stock">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                            <small class="text-danger">Warning: Enabling negative stock can cause inventory inconsistencies.</small>
                        </div>

                    </div>
                </div>


                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Save Settings
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
