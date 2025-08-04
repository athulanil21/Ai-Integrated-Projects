<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Add Patient<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Add New Patient<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Patient Information</h3>
            </div>
            
            <?= form_open('admin/patients/create', ['class' => 'form-horizontal']) ?>
            <div class="card-body">
                <div class="form-group row">
                    <label for="mr_id" class="col-sm-3 col-form-label">MR ID *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="mr_id" name="mr_id" 
                               value="<?= old('mr_id') ?>" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="first_name" class="col-sm-3 col-form-label">First Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="first_name" name="first_name" 
                               value="<?= old('first_name') ?>" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="last_name" class="col-sm-3 col-form-label">Last Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="last_name" name="last_name" 
                               value="<?= old('last_name') ?>" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="date_of_birth" class="col-sm-3 col-form-label">Date of Birth *</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                               value="<?= old('date_of_birth') ?>" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="gender" class="col-sm-3 col-form-label">Gender *</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Female</option>
                            <option value="other" <?= old('gender') === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label">Phone *</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?= old('phone') ?>" required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= old('email') ?>">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="address" name="address" rows="3"><?= old('address') ?></textarea>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="emergency_contact" class="col-sm-3 col-form-label">Emergency Contact</label>
                    <div class="col-sm-9">
                        <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" 
                               value="<?= old('emergency_contact') ?>">
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-sm-9 offset-sm-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="whatsapp_opted" 
                                   name="whatsapp_opted" value="1" <?= old('whatsapp_opted') ? 'checked' : '' ?>>
                            <label class="form-check-label" for="whatsapp_opted">
                                Opt for WhatsApp notifications
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Patient</button>
                <a href="<?= base_url('admin/patients') ?>" class="btn btn-secondary">Cancel</a>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
