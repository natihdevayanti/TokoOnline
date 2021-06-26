<?php

$success    = $this->session->flashdata('success');
$error      = $this->session->flashdata('error');
$warning    = $this->session->flashdata('warning');


if ($success) {
    $alert_status   = 'alert-success';
    $status         = 'Success!';
    $message        = $success;
    unset($_SESSION['success']);
}

if ($error) {
    $alert_status   = 'alert-danger';
    $status         = 'Error!';
    $message        = $error;
    unset($_SESSION['error']);
}

if ($warning) {
    $alert_status   = 'alert-warning';
    $status         = 'Warning!';
    $message        = $warning;
    unset($_SESSION['warning']);
}

if ($success || $error || $warning) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert <?= $alert_status ?> alert-dismissible fade show" role="alert">
                <strong><?= $status ?></strong> <?= $message ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
<?php endif ?>