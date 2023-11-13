<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER TACHE - PAGE
<?php $this->endsection() ?>

<?php $this->section('Commeciale') ?>
active
<?php $this->endsection() ?>
<?php $this->section('Commecialeadd') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Commerciale</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Ajouter Commerciale</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php $successFlash = session()->getFlashdata('success'); ?>
<?php if (isset($successFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-success">
            <?= $successFlash ?>
        </div>
    </div>
<?php endif; ?>
<?php $errorFlash = session()->getFlashdata('error'); ?>
<?php if (isset($errorFlash)): ?>
    <div class="row" id="myDiv">
        <div class="alert alert-danger">
            <?= $errorFlash ?>
        </div>
    </div>
<?php endif; ?>

<section class="content">
    <!-- general form elements disabled -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ajouter Commerciale</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form class="form-horizontal" method="post" action="<?= base_url('/Commeciale/save') ?>">
            </form>
        </div>
    </div>
</section>

<?php $this->endsection() ?>