<!-- Content Page -->
<div class="container">
    
    <!-- Header -->
    <div class="content-header">

        <!-- Import Button -->
        <a data-toggle="modal" data-target="#modalImport" class="btn btn-sm btn-success">
            <i class="fas fa-file-import"></i> Import
        </a>

        <a class="btn btn-sm btn-danger" href="<?= base_url('home/clear')?>">
            <i class="fas fa-trash"></i> Clear
        </a>

        <!-- Export Button -->
        <a data-toggle="modal" data-target="#modalExport" class="btn btn-sm btn-primary float-right">
            <i class="fas fa-download"></i> Export
        </a>

    </div>

    <!-- Table Transaction -->
    <div class="table-responsive">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th class="border align-middle" rowspan="2">NO</th>
                    <th class="border" colspan="6">Kriteria</th>
                    <th class="border">Target</th>
                </tr>
                <tr>
                    <th class="border">A</th>
                    <th class="border">B</th>
                    <th class="border">C</th>
                    <th class="border">D</th>
                    <th class="border">E</th>
                    <th class="border">F</th>
                    <th class="border">Z</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($transaction_list as $key => $transaction) { ?>
                <tr class="text-center">
                    
                    <!-- Number -->
                    <td class="border"><?= $key+1 ?></td>
                    <td class="border"><?= $transaction['A'] ?></td>
                    <td class="border"><?= $transaction['B'] ?></td>
                    <td class="border"><?= $transaction['C'] ?></td>
                    <td class="border"><?= $transaction['D'] ?></td>
                    <td class="border"><?= $transaction['E'] ?></td>
                    <td class="border"><?= $transaction['F'] ?></td>
                    <td class="border"><?= $transaction['Z'] ?></td>

                </tr>
                <?php } ?>
                <tr><td colspan="8"></td></tr>
                <tr class="">
                    <td class="border">#</td>
                    <td class="border">A1 = <?= $total[0]['A1']?></td>
                    <td class="border">B1 = <?= $total[0]['B1']?></td>
                    <td class="border">C1 = <?= $total[0]['C1']?></td>
                    <td class="border">D1 = <?= $total[0]['D1']?></td>
                    <td class="border">E1 = <?= $total[0]['E1']?></td>
                    <td class="border">F1 = <?= $total[0]['F1']?></td>
                    <td class="border">Z1 = <?= $total[0]['Z1']?></td>
                </tr>
                <tr class="">
                    <td class="border">#</td>
                    <td class="border">A2 = <?= $total[0]['A3']?></td>
                    <td class="border">B2 = <?= $total[0]['B3']?></td>
                    <td class="border">C2 = <?= $total[0]['C3']?></td>
                    <td class="border">D2 = <?= $total[0]['D3']?></td>
                    <td class="border">E2 = <?= $total[0]['E3']?></td>
                    <td class="border">F2 = <?= $total[0]['F3']?></td>
                    <td class="border">Z2 = <?= $total[0]['Z3']?></td>
                </tr>
                <tr class="">
                    <td class="border">#</td>
                    <td class="border">A3 = <?= $total[0]['A3']?></td>
                    <td class="border">B3 = <?= $total[0]['B3']?></td>
                    <td class="border">C3 = <?= $total[0]['C3']?></td>
                    <td class="border">D3 = <?= $total[0]['D3']?></td>
                    <td class="border">E3 = <?= $total[0]['E3']?></td>
                    <td class="border">F3 = <?= $total[0]['F3']?></td>
                    <td class="border">Z3 = <?= $total[0]['Z3']?></td>
                </tr>
                
                <!-- Empty State -->
                <?php if(empty($transaction_list)) { ?>
                    <tr class="text-center"><td colspan="8">Data not found</td></tr>
                <?php } ?>

            </tbody>

        </table>
    </div>

</div>

<!-- Load Modal Views -->
<?php 
    $this->load->view('frontend/homepage/modal-export-excel'); 
    $this->load->view('frontend/homepage/modal-import-excel');
?>
