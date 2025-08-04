<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Patients<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Patient Management<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Patients</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Patients</h3>
                <div class="card-tools">
                    <a href="<?= base_url('admin/patients/create') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Patient
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="patientsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>MR ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>WhatsApp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?= $patient['patient_id'] ?></td>
                            <td><?= $patient['mr_id'] ?></td>
                            <td><?= $patient['first_name'] . ' ' . $patient['last_name'] ?></td>
                            <td><?= $patient['phone'] ?></td>
                            <td><?= ucfirst($patient['gender']) ?></td>
                            <td>
                                <?php if ($patient['whatsapp_opted']): ?>
                                    <span class="badge badge-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">No</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/patients/view/' . $patient['patient_id']) ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= base_url('admin/patients/edit/' . $patient['patient_id']) ?>" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm" 
                                        onclick="deletePatient('<?= $patient['patient_id'] ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#patientsTable').DataTable();
});

function deletePatient(patientId) {
    if (confirm('Are you sure you want to delete this patient?')) {
        window.location.href = '<?= base_url('admin/patients/delete/') ?>' + patientId;
    }
}
</script>
<?= $this->endSection() ?>
