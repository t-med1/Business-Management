<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
DETAIL CONGE - PAGE
<?php $this->endsection() ?>

<?php $this->section('conge') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Congées</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Détails Congées</li>
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Liste Des Tâches pour chaque Commerciale</h3>
                        </div>
                        <div class="card-body">
                        <table id="myDataTable" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Nom et Prénom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th colspan="4">Durée du congé</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('Commerciale/details/'.$employee['id_emp'])?>"
                                            data-toggle="tooltip" data-placement="top" title="Voir Ce Commercial">
                                            <strong>
                                                <?= $employee['nom'] ?> <?= $employee['prenom'] ?>
                                            </strong>
                                        </a>
                                    </td>
                                    <td>
                                        <?= $employee['telephone'] ?>
                                    </td>
                                    <td>
                                        <?= $employee['email'] ?>
                                    </td>
                                    <td>
                                        <?= $employee['role'] ?>
                                    </td>
                                    <td rowspan="<?= $congesCount ?>">
                                        <?php foreach ($conges as $conge): ?>
                                            <?= $conge['date_debutC'] ?>&nbsp;&nbsp;<i class="fa fa-arrow-right"
                                                aria-hidden="true" style="color:red"></i>&nbsp;&nbsp;
                                            <?= $conge['date_fin'] ?><br><br>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
<?php $this->endsection() ?>