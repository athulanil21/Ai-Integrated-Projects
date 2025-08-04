<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('page_title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?= $stats['total_patients'] ?></h3>
                <p>Total Patients</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="<?= base_url('admin/patients') ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $stats['today_appointments'] ?></h3>
                <p>Today's Appointments</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="<?= base_url('appointments') ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>₹<?= number_format($stats['monthly_revenue'], 2) ?></h3>
                <p>Monthly Revenue</p>
            </div>
            <div class="icon">
                <i class="fas fa-rupee-sign"></i>
            </div>
            <a href="<?= base_url('reports/billing') ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $stats['low_stock_items'] ?></h3>
                <p>Low Stock Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="<?= base_url('inventory') ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Upcoming Appointments</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcoming_appointments as $appointment): ?>
                        <tr>
                            <td><?= date('H:i', strtotime($appointment['appointment_time'])) ?></td>
                            <td><?= $appointment['first_name'] . ' ' . $appointment['last_name'] ?></td>
                            <td><?= $appointment['doctor_name'] ?></td>
                            <td><?= $appointment['study_type'] ?></td>
                            <td>
                                <span class="badge badge-<?= $appointment['status'] === 'scheduled' ? 'primary' : 'success' ?>">
                                    <?= ucfirst($appointment['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">WhatsApp Status</h3>
            </div>
            <div class="card-body">
                <div class="progress-group">
                    Sent Messages
                    <span class="float-right"><b><?= $whatsapp_stats['sent'] ?></b>/<?= $whatsapp_stats['total'] ?></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-primary" 
                             style="width: <?= $whatsapp_stats['total'] > 0 ? ($whatsapp_stats['sent'] / $whatsapp_stats['total']) * 100 : 0 ?>%"></div>
                    </div>
                </div>
                
                <div class="progress-group">
                    Delivered Messages
                    <span class="float-right"><b><?= $whatsapp_stats['delivered'] ?></b>/<?= $whatsapp_stats['total'] ?></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" 
                             style="width: <?= $whatsapp_stats['total'] > 0 ? ($whatsapp_stats['delivered'] / $whatsapp_stats['total']) * 100 : 0 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
