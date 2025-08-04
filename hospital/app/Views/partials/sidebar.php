<?php
$userRole = session()->get('role_id');
$currentUri = uri_string();
?>

<li class="nav-item">
    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $currentUri === 'dashboard' ? 'active' : '' ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>

<?php if ($userRole == 1): // Admin ?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Patient Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('admin/patients') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Patients</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('admin/patients/create') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Patient</p>
            </a>
        </li>
    </ul>
</li>
<?php endif; ?>

<li class="nav-item has-treeview <?= strpos($currentUri, 'appointments') !== false ? 'menu-open' : '' ?>">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>
            Appointments
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('appointments') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Appointments</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('appointments/create') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Schedule Appointment</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-file-invoice-dollar"></i>
        <p>
            Billing & Finance
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('billing') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daily Billing</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('expenses') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Expenses</p>
            </a>
        </li>
    </ul>
</li>

<?php if ($userRole == 1): // Admin ?>
<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-boxes"></i>
        <p>
            Inventory
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('inventory') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock Management</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('inventory/transactions') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Transactions</p>
            </a>
        </li>
    </ul>
</li>
<?php endif; ?>

<li class="nav-item has-treeview">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-bar"></i>
        <p>
            Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="<?= base_url('reports/patients') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Patient Reports</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('reports/appointments') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Appointment Reports</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('reports/billing') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Financial Reports</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="<?= base_url('whatsapp/status') ?>" class="nav-link">
        <i class="nav-icon fab fa-whatsapp"></i>
        <p>WhatsApp Status</p>
    </a>
</li>
