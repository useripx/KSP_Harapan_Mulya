<div class="ttd-container d-none d-print-flex justify-content-between align-items-end mt-5 pt-4 border-top">
    
    <div class="d-flex flex-column align-items-center text-center" style="width: 200px;">
        <p class="small text-muted mb-3">Mengetahui,<br>Manager Koperasi</p>
        <div class="bg-white p-1 border rounded shadow-sm mb-2">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=MANAGER_APPROVE" alt="QR" width="70" height="70">
        </div>
        <p class="fw-bold border-bottom border-dark pb-1 px-3 mt-2 mb-0">Bpk. Haryanto, SE</p>
    </div>

    <div class="d-flex flex-column align-items-center text-center" style="width: 200px;">
        <p class="small text-muted mb-1">Kediri, <?= date('d F Y') ?></p>
        <p class="small text-muted mb-3">Dibuat Oleh,<br>Validator / Staff</p>
        <div class="bg-white p-1 border rounded shadow-sm mb-2">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=VALIDATOR_<?= $_SESSION['user_id'] ?? 'SYS' ?>" alt="QR" width="70" height="70">
        </div>
        <p class="fw-bold border-bottom border-dark pb-1 px-3 mt-2 mb-0"><?= e($_SESSION['user_name'] ?? 'Admin') ?></p>
    </div>

</div>