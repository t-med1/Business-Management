<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER TACHE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
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
                <?= csrf_field() ?>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Code Employé <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Code ..."
                            value="<?= $employeeCode ?>" name="codeEmp" readonly>
                    </div>
                    <div class="col-sm-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="email" placeholder="Email ..." name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Nom ..." name="nom" required>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label">Téléphone <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Téléphone ..." name="telephone">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Prénom <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" placeholder="Prénom" name="prenom" required>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label">Rôle <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" name="role">
                            <option>Selectionner Un Rôle</option>
                            <option value="admin">Admin</option>
                            <option value="gestionnaire">Géstionnaire</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="form-label">Date Début <span class="text-danger"></span></label>
                    </div>
                    <div class="col-sm-3">
                        <input class="form-control" type="date" name="date_debut">
                    </div>
                </div>
                <div class="row" style="display:flex; justify-content:center">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-outline-info btn-block btn-flat" style="border-radius:10px;"><i
                            class="fa fa-book"></i> Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="content">
    <div class="col-xs-12 no-print" style="display:flex;justify-content:space-between">
        <a href="/Commeciale" class="btn btn-default pull-right">
            <i class="fa fa-reply"></i> Retour
        </a>
    </div>
</section>

<?php $this->endsection() ?>

<?php $this->section('script') ?>
<script>
    $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
})
</script>
<?php $this->endsection() ?>