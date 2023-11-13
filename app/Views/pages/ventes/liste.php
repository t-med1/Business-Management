<?php $this->extend('templates/layout') ?>

<?php $this->section('title') ?>
VENTES LIST - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<?php $this->endsection() ?>
<?php $this->section('Vente') ?>
active
<?php $this->endsection() ?>
<?php $this->section('Ventel') ?>
active
<?php $this->endsection() ?>

<?php $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Ventes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                    <li class="breadcrumb-item active">Liste Ventes</li>
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
                        <h3 class="card-title">Filtrer Les Ventes</h3>
                    </div>
                    <div class="card-body">

                        <form method="get" action="">

                            <div class="row">

                                <div class="col-md-3"></div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label>Entre Le :</label>

                                        <input type="date" class="form-control" name="date_debut"
                                            value="<?= $debut ?>" required>

                                    </div>
                                </div>

                                <div class="col-md-3">

                                    <div class="form-group">

                                        <label>Et Le :</label>

                                        <input type="date" class="form-control" name="date_fin"
                                            value="<?= $fin ?>" required>

                                    </div>

                                </div>

                                <div class="col-md-3"></div>

                            </div>

                            <div class="row">

                                <div class="col-md-3"></div>

                                <div class="col-md-6">

                                    <button class="btn btn-info"
                                        style="width:100%; box-shadow: 8px 8px 2px #ECF0EF;">
                                        <i class="fa fa-search"></i> &nbsp; Filtrer
                                    </button>



                                </div>

                                <div class="col-md-3"></div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Liste Des Ventes</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>N° de Vente</th>
                                    <th>Commerciale</th>
                                    <th>Client</th>
                                    <th>Date Vente</th>
                                    <th>Total HT</th>
                                    <th>Total TTC</th>
                                    <th>Resté a payé</th>
                                    <th style="width: 150px" class="text-center">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($ventes)) : ?>
                                        <?php $count = 0 ; foreach ($ventes as $vente) : ?>
                                            <tr>
                                                <td>
                                                    <?= $vente['code_vente'] ?>
                                                </td>
                                                <td>
                                                <span class="badge <?= $vente['role'] == 'admmin' ? 'bg-success' : "bg-warning"?> custom-tooltip" data-toggle="tooltip" data-placement="top" title="<?= $vente['role'] ?>">
                                                    <?= $vente['nom'].' '.$vente['prenom'] ?>
                                                </span>

                                                </td>
                                                <td>
                                                    <a href="<?= base_url('/client')?>" data-toggle="tooltip" data-placement="top" title="Voir Les Détails De Ce Client" style="text-decoration:none;font-weight:bold">
                                                        <?= $vente['societe'] ?>
                                                    </a><br>
                                                    <span>
                                                        ( <?= $vente['mode_paiement'] ?> )
                                                    </span>
                                                </td>
                                                <td><?= $vente['date_vente'] ?></td>
                                                <td><?= $vente['total_ht'] ?></td>
                                                <td><?= $vente['total_ttc'] ?></td>
                                                <td>
                                                    <?php if($vente['montant_rest'] == 0) : ?>
                                                        <strong style="color: #00CC00">Payé</strong>
                                                    <?php else:?>
                                                        <strong style="color: #e9322d"><?= $vente['montant_rest'] ?> Dh</strong>
                                                    <?php endif;?>
                                                </td>

                                                <input type="hidden" name="" id="hiddeninp<?= $count ?>" value="<?= $vente['montant_rest']?>">
                                                <td class="text-center">
												    <div class="btn-container" style="display:flex;justify-content:center;gap:5px">
                                                    <?php if ($vente ['montant_rest'] > 0 && $vente['mode_paiement'] !== 'cheque'): ?>
                                                        <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#exampleModal<?= $count ?>">
                                                            <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-eur" aria-hidden="true"></i>
                                                        </button>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal<?= $count ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Ajouter Paiement</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?= base_url('rest/update/'.$vente['id_vente'])?>" method="post">
                                                                <?= csrf_field() ?>
                                                                    <div class="row mb-2">
                                                                        <label for="paiement" class="form-label"><span style="color:red;">*</span>Paiement <small>DH</small></label>
                                                                        <input type="number" class="form-control" name="montant_pay" id="paiement<?=$count?>" placeholder="Entrer un paiement" required>
                                                                        <input type="hidden" class="form-control" name="date_dernier_paiment" value="<?= date('Y-m-d')?>">
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <label for="reste" class="form-label"><span style="color:red;">*</span>Reste <small>DH</small></label>
                                                                        <input type="number" class="form-control" id="reste<?=$count?>" data-initial="<?= $vente['montant_rest'] ?>" value="<?= $vente['montant_rest'] ?>" name="motant_rest" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" id="cancelBtn<?=$count?>" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Annuler</button>
                                                                    <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    <?php elseif($vente['mode_paiement'] == 'cheque'):?>
                                                        <?php if($vente['montant_rest'] != 0):?>
                                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#exampleModal2">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> <i class="fa fa-money" aria-hidden="true"></i>
                                                            </button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="<?= base_url('update/cheque/'.$vente['id_vente'])?>" method="post">
                                                                            <?= csrf_field()?>
                                                                            <div class="modal-body" style="display:flex;justify-content:space-around">
                                                                                <input type="hidden" name="date_dernier_paiment" value="<?= date('Y-m-d')?>">
                                                                                <button type="button" class="btn btn-danger" id="" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Annuler</button>
                                                                                <button type="submit" class="btn btn-info"><i class="fa fa-floppy-o" aria-hidden="true"></i> Enregistrer Le Paiement</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif;?>
                                                    <?php endif; ?>
                                                            <a href="<?= base_url('vente/details/' . $vente['id_vente']) ?>"
                                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Détails">
                                                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="<?= base_url('vente/modifier/' . $vente['id_vente']) ?>"
                                                                class="btn btn-success btn-sm" data-toggle="tooltip"
                                                                data-placement="top" title="Modifier">
                                                                <i class="fa fa-wrench" aria-hidden="true"></i>
                                                            </a>
												    </div>
											    </td>
                                            </tr>
                                        <?php $count++ ; endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="7" style="text-align:center" class="bg-light">
                                                <p>Aucune vente trouvée...</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $this->endsection() ?>
<?php $this->section('script')?>
<script>
    $(document).ready(function () {
    <?php for ($i = 0; $i < $count; $i++) : ?>
        $('#reste<?= $i ?>').val($('#hiddeninp<?= $i ?>').val());
        function updateReste<?= $i ?>() {
            var paiement = parseFloat($('#paiement<?= $i ?>').val());
            var initialReste = parseFloat($('#reste<?= $i ?>').data('initial'));

            if (isNaN(paiement)) {
                $('#reste<?= $i ?>').val(initialReste);
            } else {
                var MontantReste = initialReste - paiement;
                $('#reste<?= $i ?>').val(MontantReste);
            }
        }
        $('#cancelBtn<?= $i ?>').on('click' , function(){
            $('#reste<?= $i ?>').val($('#hiddeninp<?= $i ?>').val());
            $('#paiement<?= $i ?>').val(0)

        });
        $('#paiement<?= $i ?>').on('input', function () {
            updateReste<?= $i ?>();
        });

        $('#paiement<?= $i ?>').on('blur', function () {
            updateReste<?= $i ?>();
        });

        $('#paiement<?= $i ?>').on('keydown', function (e) {
            if (e.keyCode === 8) { // Backspace key code
                updateReste<?= $i ?>();
            }
        });
    <?php endfor; ?>
});



</script>
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
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>

<?php $this->endsection()?>