<?php $this->extend("templates/layout") ?>

<?php $this->section("title") ?>
DETAIL EMPLOYE - PAGE
<?php $this->endsection() ?>

<?php $this->section("Commerciale") ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Commerciales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
              <li class="breadcrumb-item active">Liste Commerciales</li>
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
        <div class="row">
            <div class="col-md-4">
                <!-- DIRECT CHAT SUCCESS -->
                <div class="card card-success card-outline direct-chat direct-chat-success">
                        <?php if (isset($employee)): ?>
                        <div class="card-header mb-2" style="display:flex;justify-content:center">
                            <h4 style="font-weight:bold; color: #008080;">
                                <?= $employee['nom'] . ' ' . $employee['prenom'] ?>
                            </h4>
                        </div>
                        <div class="card-body">
                                <div class="row ml-4 mb-3">
                                    <span class="col-sm-3">Code</span>
                                    <span class="col-sm-1">:</span>
                                    <span class="col-sm-7" style="font-weight:bold">
                                        <a href="#"style="color:#008080;text-decoration:none;">
                                            <?= $employee['code_emp'] ?>
                                        </a>
                                    </span>
                                </div>
                                <div class="row ml-4 mb-3">
                                    <span class="col-sm-3">Email</span>
                                    <span class="col-sm-1">:</span>
                                    <span class="col-sm-7" style="font-weight:bold">
                                        <?= $employee['email'] ?>
                                    </span>
                                </div>
                                <div class="row ml-4 mb-3">
                                    <span class="col-sm-3">Téléphone</span>
                                    <span class="col-sm-1">:</span>
                                    <span class="col-sm-7" style="font-weight:bold">
                                        <?= $employee['telephone'] ?>
                                    </span>
                                </div>
                                <div class="row ml-4 mb-3">
                                    <span class="col-sm-3">Role</span>
                                    <span class="col-sm-1">:</span>
                                    <span class="col-sm-7" style="font-weight:bold">
                                        <?= $employee['role'] ?>
                                    </span>
                                </div>
                                <div class="row mb-3" style="display:flex;justify-content:center">
                                    <span class="col-sm-4">
                                        <a href="/Commeciale/edit/<?= $employee['id_emp'] ?>" class="btn btn-outline-success btn-flat"
                                            style="border-radius: 15px;">
                                            <i class="fa fa-wrench" aria-hidden="true"></i>
                                            Modifier
                                        </a>
                                    </span>
                                </div>
                                <div class="row">

                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
            <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Les Taches</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Etat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($taches): ?>
                                        <?php foreach ($taches as $tache): ?>
                                            <tr>
                                                <td>
                                                    <?= $tache['description'] ?>
                                                </td>
                                                <td>
                                                    
                                                    <?php if ($tache['statut'] == 'en attente'): ?>
                                                        <div style="display:flex;justify-content:center">
                                                            <button class="btn btn-dark btn-icon-text btn-sm" <?= session('role')=='admin' ? 'disabled' : '' ?>>
                                                                To Do
                                                                <i class="fa fa-folder" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    <?php elseif ($tache['statut'] == 'en cours'): ?>
                                                        <div style="display:flex;justify-content:center">
                                                            <button class="btn btn-warning btn-rounded btn-icon"
                                                                data-toggle="tooltip" data-placement="top" title="En Cours" <?= session('role')=='admin' ? 'disabled' : '' ?>>
                                                                En Cours
                                                                <i class="fa fa-spinner" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    <?php elseif ($tache['statut'] == 'terminée'): ?>
                                                        <div style="display:flex;justify-content:center">
                                                            <button class="btn btn-success btn-icon-text btn-sm" <?= session('role')=='admin' ? 'disabled' : '' ?>>
                                                                Done
                                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    <?php elseif ($tache['statut'] == "en retard"): ?>
                                                        <form
                                                            action="<?= base_url('TacheController/updateStatut/' . $tache["id_tache"]) ?>">
                                                            <button class="btn btn-danger btn-icon-text btn-sm"
                                                                <?= session('role')=='admin' ? 'disabled' : '' ?>>
                                                                Retard
                                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <td colspan="2" class="bg-light" style="text-align:center;">
                                            <p>Aucune sous tâche trouvé...</p>
                                        </td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-solid">
                    <div class="card-header with-border">
                        <h3 class="card-title">Les 10 Dernière Activitées</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                    <table id="example1" class="table myDataTable table-bordered table-striped">
                                <thead>
                                    <th>Commerciale</th>
                                    <th colspan="6">Dernière Activité</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="badge <?= $employee['role']=='admin'?'bg-success':'bg-warning'?> custom-tooltip"  data-toggle="tooltip" data-placement="top"
                                                title="<?= $employee['role']?>">
                                                <?= $employee['nom'] . ' ' . $employee['prenom'] ?>
                                            </span>
                                        </td>
                                        <?php if(!empty($logs)):?>
                                            <td colspan="6">
                                            <?php foreach($logs as $log):?>
                                                    <div class="row mb-2">
                                                        <span><?= $log['date_log']?>&nbsp; &nbsp;<b><?= $log['description']?></b></span>
                                                    </div>
                                                <?php endforeach;?>
                                            </td>
                                        <?php else:?>
                                            <td colspan="6" class="text-center bg-light">
                                                    <span><p>Aucune Activité trouvée...</p></span>
                                            </td>
                                            <?php endif;?>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
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
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
<?php $this->endsection() ?>

