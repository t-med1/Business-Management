<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER TACHE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('tachesadd') ?>
active
<?php $this->endsection() ?>
<?php $this->section('taches') ?>
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
                    <li class="breadcrumb-item active">Ajouter Tâches</li>
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
        <h3 class="card-title">Ajouter Tâches</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form method="post" action="<?= base_url('tache/save') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Commerciale<span class="text-danger">*</span> : </label>
                        <select class="form-control" name="code_emp" id="code_emp" required>
                            <option value="">Sélectionner un Commerciale</option>
                            <?php foreach ($employeeData as $employee): ?>
                                <option value="<?= $employee['code_emp'] ?>"><?= $employee['nom'] ?>     <?= $employee['prenom'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email :</label>
                        <input type="text" class="form-control" type="email" placeholder="Email ..." name="email"
                            id="email" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nom :</label>
                        <input class="form-control" type="text" placeholder="Nom ..." name="nom" id="nom" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Téléphone :</label>
                        <input class="form-control" type="text" placeholder="Téléphone ..." name="telephone"
                            id="telephone" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Prénom :</label>
                        <input class="form-control" type="text" placeholder="Prénom ..." name="prenom" id="prenom"
                            readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Rôle :</label>
                        <input class="form-control" type="text" placeholder="Rôle ..." name="role" id="role" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date Début<span class="text-danger">*</span> :</label>
                        <input class="form-control" type="date" name="date_debutT" id="date_debutT" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Date Fin<span class="text-danger">*</span> :</label>
                        <input class="form-control" type="date" name="date_fin" id="date_fin" required>
                        <p id="p" class='text-danger'></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Description<span class="text-danger">*</span> :</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name='description'
                            required></textarea>
                    </div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#code_emp').on('change', function () {
            var code_emp = $('#code_emp option:selected').val();

            $.ajax({
                url: '/getEmployeeInfo/' + code_emp,
                type: 'GET',
                success: function (response) {
                    $('#email').val(response.email);
                    $('#nom').val(response.nom);
                    $('#prenom').val(response.prenom);
                    $('#telephone').val(response.telephone);
                    $('#role').val(response.role);
                    $('#role').val(response.role);
                    console.log(response);
                },
                error: function (error) {
                    console.log('AJAX Error:', error);
                }
            });
        });

        $('#date_fin').on('change', function () {
            var dateDebut = new Date($('#date_debutT').val());
            var dateFin = new Date($('#date_fin').val());

            if (dateDebut > dateFin) {
                $('#date_fin').removeClass('is-valid');
                $('#date_fin').addClass('is-invalid');
                $('#p').html('la date Début doit être supérieur à la date fin')
            } else {
                $('#date_fin').removeClass('is-invalid');
                $('#date_fin').addClass('is-valid');
                $('#p').html('')
            }
        });
    });
    ;


</script>
<?php $this->endsection() ?>