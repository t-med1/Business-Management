<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
MODIFIER TACHE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section("taches") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tâches</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Modifier Tâche</li>
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
<div class="card card-info">
    <div class="card-header bg-success">
        <h3 class="card-title">Modifier Tâches</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form method="post" action="<?= base_url('taches/update/' . $tache['id_tache']) ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Code Commerciale : </label>
                        <input type="text" class="form-control" type="text" placeholder="Code Emp ..." name="code_emp"
                            id="code" value="<?= $employee['code_emp']?>" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="text" class="form-control" type="email" placeholder="Email ..." name="email"
                            id="email" value="<?= $employee['email']?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nom :</label>
                        <input class="form-control" type="text" value="<?= $employee['nom']?>" placeholder="Nom ..." name="nom" id="nom" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Téléphone :</label>
                        <input class="form-control" type="text" value="<?= $employee['telephone']?>" placeholder="Téléphone ..." name="telephone"
                            id="telephone" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Prénom :</label>
                        <input class="form-control" type="text" value="<?= $employee['prenom']?>" placeholder="Prénom ..." name="prenom" id="prenom"
                            readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Rôle :</label>
                        <input class="form-control" type="text" value="<?= $employee['role']?>" placeholder="Rôle ..." name="role" id="role" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date Début :</label>
                        <input class="form-control" type="date" value="<?= $tache['date_debutT']?>" name="date_debutT" id="date_debutT" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date Fin :</label>
                        <input class="form-control" type="date" value="<?= $tache['date_fin']?>" name="date_fin" id="date_fin" required>
                        <p id="p" class='text-danger'></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Description<span class="text-danger">*</span> :</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='description'
                            required><?= $tache['description']?></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="display:flex; justify-content:center">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-outline-success btn-block btn-flat" style="border-radius:10px;"><i
                            class="fa fa-wrench"></i> Modifier</button>
                </div>
            </div>
        </form>

    </div>
</div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function () {
            $('#date_fin').on('change', function () {
            var dateDebut = new Date($('#date_debutT').val());
            var dateFin = new Date($('#date_fin').val());

            if (dateDebut > dateFin) {
                $('#date_fin').removeClass('is-valid');
                $('#date_fin').addClass('is-invalid');
                $('#p').html('la date Début est supérieur à la date fin')
            } else {
                $('#date_fin').removeClass('is-invalid');
                $('#date_fin').addClass('is-valid');
                $('#p').html('')
            }
        });
        });
</script>
<?php $this->endsection() ?>