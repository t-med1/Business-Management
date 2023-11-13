<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
MODIFIER CONGE - PAGE
<?php $this->endsection() ?>

<?php $this->section("conge") ?>
active
<?php $this->endsection() ?>

<?php $this->section("content") ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Congées</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Modifier Congées</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="card card-info">
        <div class="card-header bg-success">
            <h3 class="card-title">Modifier Tâches</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Display employee information -->
            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="form-label">Code Employé :</label>
                    <input class="form-control" type="text" name="codeEmp"
                        value="<?= $employee['nom']; ?> <?= $employee['prenom']; ?>" readonly>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Email :</label>
                    <input class="form-control" type="email" name="email" value="<?= $employee['email']; ?>"
                        readonly>
                </div>
            </div>

            <?php foreach ($conges as $i => $congeItem): ?>
                <form method="post" action="<?= base_url('conge/update/' . $congeItem['id_conge']) ?>"
                    class="form-group row">
                    <?= csrf_field() ?>
                    <div class="col-sm-12 mb-4">
                        <label class="form-label" style="font-weight: bold; color:red;text-decoration:underline">Congé N
                            <?= $i + 1 ?>:
                        </label>
                    </div>

                    <div class="col-sm-4 mb-4">
                        <label class="form-label" style="font-weight: bold">Date Début :</label>
                        <input class="form-control" type="date" name="date_debutC"
                            value="<?= $congeItem['date_debutC'] ?>">
                    </div>

                    <div class="col-sm-4 mb-4">
                        <label class="form-label" style="font-weight: bold">Date Fin :</label>
                        <input class="form-control" type="date" name="date_fin"
                            value="<?= $congeItem['date_fin'] ?>">
                    </div>

                    <div class="col-sm-4" style="margin-top:2%">
                        <button type="submit" class="btn btn-outline-success btn-sm">Modifier</button>
                    </div>
                </form>
            <?php endforeach; ?>

        </div>
    </div>
</section>

<?php $this->endsection() ?>