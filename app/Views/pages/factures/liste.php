<?php $this->extend('templates/layout') ?>
<!-- titre du page -->
<?php $this->section('title') ?>
LISTE FACTURE - PAGE
<?php $this->endsection() ?>
<?php $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url('css/home.css')?>">
<link rel="stylesheet" href="<?= base_url('css/affichageFct2.css')?>">
<?php $this->endsection() ?>
<?php $this->section('facture') ?>
active
<?php $this->endsection() ?>
<?php $this->section('facturel') ?>
active
<?php $this->endsection() ?>

<?php $this->section("content")?>
<!-- Content Header (Page header) -->
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Factures</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('/')?>">Acceuil</a></li>
              <li class="breadcrumb-item active">Liste Factures</li>
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
                            <h3 class="card-title">Liste Des Facture</h3>
                        </div>
                        <div class="card-body">

                            <form method="get" action="<?= base_url('/facture')?>">

                                <div class="row">

                                    <div class="col-md-3"></div>

                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>Entre Le :</label>

                                            <input type="date" class="form-control" name="date_debut" value="<?= $debut?>" required>

                                        </div>
                                    </div>

                                    <div class="col-md-3">

                                        <div class="form-group">

                                            <label>Et Le :</label>

                                            <input type="date" class="form-control" name="date_fin" value="<?= $fin?>" required>

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
                            <h3 class="card-title">Liste Des Facture</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Numéro Du Facture</th>
                                        <th>Commerciale</th>
                                        <th>Nom Du Client</th>
                                        <th>Date Saisie</th>
                                        <th>Montant <small>DH</small></th>
                                        <th>Reste à payé <small>DH</small></th>
                                        <th>Jour Après Mission</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($factures):?>
                                        <?php $count = 1;
                                            foreach($factures as $facture):?>
                                            <tr>
                                                <td>
                                                    <strong class="text-info" data-toggle="tooltip" data-placement="top" title="Code Facture">
                                                        <?= $facture['code_facture']?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <strong class="badge <?= $facture['role']=='admin'?'bg-success':'bg-warning'?>" data-toggle="tooltip" data-placement="top" title="<?= $facture['role']?>">
                                                        <?= $facture['nom']?> <?= $facture['prenom']?>
                                                    </strong>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('')?>" data-toggle="tooltip" data-placement="top" title="Voir Ce Client">
                                                        <strong><?= $facture['societe']?></strong>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?= $facture['date_saisie']?>
                                                </td>
                                                <td>
                                                    <?= $facture['total_ht']?>
                                                </td>
                                                <td>
                                                    <?php if($facture['montant_rest'] == 0 ):?>
                                                        <strong class="text-success">
                                                            Tous Payé
                                                        </strong>
                                                    <?php else:?>
                                                        <?= $facture['montant_rest'] ?>
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <?php if($facture['jours_apres_emission'] == 0 ):?>
                                                        <?php if( $facture['montant_rest'] == 0 ):?>
                                                            <strong class="text-success">
                                                                Aujourd'hui
                                                            </strong>
                                                        <?php else:?>
                                                            <strong class="text-danger">
                                                                Aujourd'hui
                                                            </strong>
                                                        <?php endif;?>
                                                    <?php else:?>
                                                        <?php if( $facture['montant_rest'] == 0 ):?>
                                                            <strong class="text-success">
                                                                <?= $facture['jours_apres_emission']?>
                                                            </strong> <small>Jours</small>
                                                        <?php else:?>
                                                            <strong class="text-danger">
                                                                <?= $facture['jours_apres_emission']?>
                                                            </strong> <small>Jours</small>
                                                        <?php endif;?>
                                                        
                                                    <?php endif;?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm"
                                                        data-toggle="tooltip" placement="top" title="Imprimer">
                                                        <i class="fa fa-file-pdf-o download" aria-hidden="true" id="<?= $count ?>"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                            <tr>
                                            <td colspan="10" style="padding: 0;">
                                                <div class="devis" id="<?= 'devis' . $count ?>">
                                                    <img src="<?= base_url('css/facture.jpg')?>" width="100%" class="bg">
                                                    <p style="position: absolute; left: 25.3%; top: 22.8%; font-size: 20px;"><?= $facture['societe'] ?> </p>
                                                    <p style="position: absolute; left: 25.3%; top: 25.5%; font-size: 20px;"><?= $facture['adresse'] ?> </p>
                                                    <p style="position: absolute;  left: 44%;  top: 26.9%; font-size: 20px;"><?= $facture['ville'] ?> </p>
                                                    <p style="position: absolute;  left: 25%;  top: 28.5%; font-size: 20px;"><?= $facture['ICE'] ?> </p>
                                                    <p style="position: absolute;  left: 77%;  top: 22.8%; font-size: 20px;"><?= $facture['date_saisie'] ?> </p>
                                                    <p style="position: absolute;  left: 77%;  top: 24.3%; font-size: 20px;"><?= $facture['code_facture'] ?> </p>

                                                    <?php $count = 27.2; ?>

                                                    <div style="position: absolute; width: 80%; height: 400px; margin-left: 10%; top: <?= $count ?>%;">
                                                        <?php if (!empty($facture['services'])): ?>
                                                            <?php $services = explode(',', $facture['services']); ?>
                                                            <?php foreach ($services as $serviceId): ?>
                                                                <?php $service = $serviceModel->find($serviceId); ?>
                                                                <?php if ($service): ?>
                                                                    <div style="padding-left: 10px; height: 375px; position: absolute; width: 100px; top: <?= $count ?>%; font-size: 20px;">
                                                                        1
                                                                    </div>

                                                                    <div style="padding-left: 10px; width: 468px; height: 375px; position: absolute; left: 13%; top: <?= $count ?>%; font-size: 20px; display: flex; flex-wrap: wrap;">
                                                                        <div>
                                                                            <strong><?= $service["titre"] ?>:</strong> <span style="font-size: 17px;"><?= $service["description"] ?></span>
                                                                        </div><br><br>
                                                                    </div>

                                                                    <div style="padding-left: 10px; width: 100px; height: 375px; position: absolute; left: 72.7%; top: <?= $count ?>%; font-size: 20px;">
                                                                        <?= $service["prix_unitaire"] ?> DH
                                                                    </div>
                                                                    <?php $count += 25; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <p style="position: absolute;   left: 78%;  top: 68.8%; font-size: 20px;  width: 11%;"><?= $facture['total_ht'] ?> </p>
                                                    <p style="position: absolute;   left: 78%;  top: 72.5%; font-size: 20px;  width: 11%;"><?= $facture['tva'] ?> </p>
                                                    <p style="position: absolute;   left: 78%;  top: 74%; font-size: 20px;  width: 11%;"><?= $facture['total_ttc'] ?> </p>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                        <?php $count++ ; endforeach;?>
                                    <?php else:?>
                                        <td colspan="7" style="text-align:center" class="bg-light">
                                            <p>Aucune Facture trouvée...</p>
                                        </td>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmSwalDelete(id_facture) {
    Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Cela va supprimer cette Facture !',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= site_url('/facture/delete/') ?>' + id_facture;
        }
    });
    return false;
}
</script>
<?php $this->endsection()?>


<?php $this->section("script")?>
<script src="../../css/home.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" integrity="sha512-234m/ySxaBP6BRdJ4g7jYG7uI9y2E74dvMua1JzkqM3LyWP43tosIqET873f3m6OQ/0N6TKyqXG4fLeHN9vKkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#myDiv').slideUp();
            }, 1000);
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        console.clear()
        document.querySelectorAll('.download').forEach(btn => {
            btn.addEventListener('click', e => {
                $('#devis' + e.target.id).show()
                html2canvas(document.getElementById('devis' + e.target.id))
                    .then(canvas => {
                        let base64image = canvas.toDataURL('image/png');
                        console.log(base64image);

                        let pdf = new jsPDF('p', 'px', [1117, 1423]);
                        pdf.addImage(base64image, 'PNG', 4, -30, 1117, 1400);
                        pdf.save('Facture.pdf')
                    });
                $('#devis' + e.target.id).hide()

            })
        })
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
</script>
<?php $this->endsection() ?>