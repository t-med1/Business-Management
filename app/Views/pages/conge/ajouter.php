<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
AJOUTER CONGE - PAGE
<?php $this->endsection() ?>

<?php $this->section("congeadd") ?>
active
<?php $this->endsection("") ?>
<?php $this->section("conge") ?>
active
<?php $this->endsection("") ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Congés</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Ajouter Congés</li>
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
                    <h3 class="card-title">Ajouter Congé</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="<?= base_url('/conje/save') ?>">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Commerciale<span class="text-danger">*</span> : </label>
                                    <select class="form-control" name="nom" id="code_emp" required>
                                        <option value="">Sélectionner un Employé</option>
                                        <?php foreach ($employeeData as $employee): ?>
                                            <option value="<?= $employee['nom'] ?>"><?= $employee['nom'] ?>  <?= $employee['prenom'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date Debut<span class="text-danger">*</span> :</label>
                                    <input class="form-control" type="date" name="date_debutC" name="date_debutC" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date Fin<span class="text-danger">*</span> :</label>
                                    <input class="form-control" type="date" name="date_fin" name="date_fin" required>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:flex; justify-content:center">
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-outline-info btn-block btn-flat" style="border-radius:10px;"><i
                                        class="fa fa-book"></i>Enregistrer</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </section>

    <?php $this->endsection() ?>