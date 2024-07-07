@extends('Pengacara/Index/app')
@section('content')
<br>
<br>
<br>
<br>

<div id="hitungWaris" class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="200">
                <h1 class="heading">Penghitung Ahli Waris</h1>
                <form id="warisForm" class="narrow-w form-search d-flex flex-column align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
                    @csrf
                    <div class="form-group">
                        <label for="religion">Agama</label>
                        <select id="religion" name="religion" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Agama</option>
                            <option value="Islam">Islam</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="deceasedGroup" style="display: none;">
                        <label for="deceased">Siapa yang meninggal?</label>
                        <select id="deceased" name="deceased" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="totalAssetGroup" style="display: none;">
                        <label for="totalAsset">Total Aset</label>
                        <input type="text" id="totalAsset" name="totalAsset" class="form-control px-4" placeholder="Masukkan total aset" required>
                        <small class="form-text text-muted">Kalkulasikan aset ke dalam rupiah</small>
                    </div>
                    <div class="form-group mt-3" id="debtGroup" style="display: none;">
                        <label for="debt">Total Hutang</label>
                        <input type="text" id="debt" name="debt" class="form-control px-4" placeholder="Masukkan total hutang" value="0" required>
                        <small class="form-text text-muted">Kalkulasikan hutang ke dalam rupiah</small>
                    </div>
                    <div class="form-group mt-3" id="wasiatGroup" style="display: none;">
                        <label for="wasiat">Wasiat (maksimal 1/3 Harta Warits)</label>
                        <input type="text" id="wasiat" name="wasiat" class="form-control px-4" placeholder="Masukkan wasiat" value="0" required>
                        <small class="form-text text-muted">Kalkulasikan wasiat ke dalam rupiah</small>
                    </div>
                    <div class="form-group mt-3" id="tajhizGroup" style="display: none;">
                        <label for="tajhiz">Biaya Tajhiz (pengurusan jenazah)</label>
                        <input type="text" id="tajhiz" name="tajhiz" class="form-control px-4" placeholder="Masukkan biaya tajhiz" value="0" required>
                        <small class="form-text text-muted">Kalkulasikan biaya tajhiz ke dalam rupiah</small>
                    </div>
                    <div class="form-group mt-3" id="alIrtsGroup" style="display: none;">
                        <label for="alIrts">Harta siap dibagi</label>
                        <input type="text" id="alIrts" name="alIrts" class="form-control px-4" readonly>
                    </div>
                    <div class="form-group mt-3" id="numWivesGroup" style="display: none;">
                        <label for="numWives">Berapa jumlah istri?</label>
                        <input type="number" id="numWives" name="numWives" class="form-control px-4" min="1" value="1" required>
                    </div>
                    <div class="form-group mt-3" id="childrenGroup" style="display: none;">
                        <label for="children">Apakah ada anak?</label>
                        <select id="children" name="children" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="yes">Ya</option>
                            <option value="no">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="numSonsGroup" style="display: none;">
                        <label for="numSons">Berapa jumlah anak laki-laki?</label>
                        <input type="number" id="numSons" name="numSons" class="form-control px-4" min="0" value="0" required>
                    </div>
                    <div class="form-group mt-3" id="numDaughtersGroup" style="display: none;">
                        <label for="numDaughters">Berapa jumlah anak perempuan?</label>
                        <input type="number" id="numDaughters" name="numDaughters" class="form-control px-4" min="0" value="0" required>
                    </div>
                    <div class="form-group mt-3" id="parentGroup" style="display: none;">
                        <label for="parents">Apakah ayah atau ibu masih ada?</label>
                        <select id="parents" name="parents" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="both">Keduanya</option>
                            <option value="none">Tidak ada</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="grandparentGroup" style="display: none;">
                        <label for="grandparents">Apakah kakek atau nenek masih ada?</label>
                        <select id="grandparents" name="grandparents" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="kakek">Kakek</option>
                            <option value="nenek">Nenek</option>
                            <option value="both">Keduanya</option>
                            <option value="none">Tidak ada</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="siblingsGroup" style="display: none;">
                        <label for="siblings">Apakah ada saudara sekandung?</label>
                        <select id="siblings" name="siblings" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="yes">Ya</option>
                            <option value="no">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="numBrothersGroup" style="display: none;">
                        <label for="numBrothers">Berapa jumlah saudara laki-laki sekandung?</label>
                        <input type="number" id="numBrothers" name="numBrothers" class="form-control px-4" min="0" value="0" required>
                    </div>
                    <div class="form-group mt-3" id="numSistersGroup" style="display: none;">
                        <label for="numSisters">Berapa jumlah saudara perempuan sekandung?</label>
                        <input type="number" id="numSisters" name="numSisters" class="form-control px-4" min="0" value="0" required>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="calculateButton">Hitung</button>
                    <button type="reset" class="btn btn-secondary mt-3" id="resetButton">Reset</button>
                </form>               
            </div>
        </div>
    </div>
</div>
<div id="hasilhitung" class="section" style="display: none;">
    <div class="container">
        <h2>Hasil Pembagian Waris</h2>
        <table class="table table-bordered">
            <tbody id="hasilTableBody">
            </tbody>
        </table>
        <button type="reset" class="btn btn-secondary mt-3" id="recalculateButton">Hitung Ulang</button>
    </div>
</div>
@endsection

@push('footer-script')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const religionSelect = document.getElementById("religion");
    const deceasedGroup = document.getElementById("deceasedGroup");
    const totalAssetGroup = document.getElementById("totalAssetGroup");
    const debtGroup = document.getElementById("debtGroup");
    const wasiatGroup = document.getElementById("wasiatGroup");
    const tajhizGroup = document.getElementById("tajhizGroup");
    const alIrtsGroup = document.getElementById("alIrtsGroup");
    const numWivesGroup = document.getElementById("numWivesGroup");
    const childrenGroup = document.getElementById("childrenGroup");
    const numSonsGroup = document.getElementById("numSonsGroup");
    const numDaughtersGroup = document.getElementById("numDaughtersGroup");
    const parentGroup = document.getElementById("parentGroup");
    const grandparentGroup = document.getElementById("grandparentGroup");
    const siblingsGroup = document.getElementById("siblingsGroup");
    const numBrothersGroup = document.getElementById("numBrothersGroup");
    const numSistersGroup = document.getElementById("numSistersGroup");
    const totalAssetInput = document.getElementById("totalAsset");
    const debtInput = document.getElementById("debt");
    const wasiatInput = document.getElementById("wasiat");
    const tajhizInput = document.getElementById("tajhiz");
    const alIrtsInput = document.getElementById("alIrts");
    const childrenSelect = document.getElementById("children");
    const deceasedSelect = document.getElementById("deceased");
    const parentsSelect = document.getElementById("parents");
    const grandparentsSelect = document.getElementById("grandparents");
    const siblingsSelect = document.getElementById("siblings");
    const calculateButton = document.getElementById("calculateButton");
    const resetButton = document.getElementById("resetButton");
    const recalculateButton = document.getElementById("recalculateButton");
    const hasilSection = document.getElementById("hasilhitung");
    const hasilTableBody = document.getElementById("hasilTableBody");

    function resetGroups() {
        totalAssetGroup.style.display = "none";
        debtGroup.style.display = "none";
        wasiatGroup.style.display = "none";
        tajhizGroup.style.display = "none";
        alIrtsGroup.style.display = "none";
        numWivesGroup.style.display = "none";
        childrenGroup.style.display = "none";
        numSonsGroup.style.display = "none";
        numDaughtersGroup.style.display = "none";
        parentGroup.style.display = "none";
        grandparentGroup.style.display = "none";
        siblingsGroup.style.display = "none";
        numBrothersGroup.style.display = "none";
        numSistersGroup.style.display = "none";
    }

    function displayGroups(deceasedValue) {
        totalAssetGroup.style.display = "block";
        debtGroup.style.display = "block";
        wasiatGroup.style.display = "block";
        tajhizGroup.style.display = "block";
        alIrtsGroup.style.display = "block";
        numWivesGroup.style.display = "block";
        childrenGroup.style.display = "block";
        parentGroup.style.display = "block";
    }

    function formatToRupiah(value) {
        return 'Rp ' + value.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }

    function calculateInheritance() {
        const totalAsset = parseInt(totalAssetInput.value.replace(/\D/g, ''), 10) || 0;
        const debt = parseInt(debtInput.value.replace(/\D/g, ''), 10) || 0;
        const wasiat = parseInt(wasiatInput.value.replace(/\D/g, ''), 10) || 0;
        const tajhiz = parseInt(tajhizInput.value.replace(/\D/g, ''), 10) || 0;
        const netAsset = totalAsset - debt - wasiat - tajhiz;
        alIrtsInput.value = formatToRupiah(netAsset);

        const deceased = deceasedSelect.value;
        const numWives = parseInt(document.getElementById("numWives").value, 10) || 0;
        const numSons = parseInt(document.getElementById("numSons").value, 10) || 0;
        const numDaughters = parseInt(document.getElementById("numDaughters").value, 10) || 0;
        const parents = parentsSelect.value;
        const grandparents = grandparentsSelect.value;
        const siblings = siblingsSelect.value === "yes";
        const numBrothers = parseInt(document.getElementById("numBrothers").value, 10) || 0;
        const numSisters = parseInt(document.getElementById("numSisters").value, 10) || 0;

        let spouseShare = 0;
        let sonsShare = 0;
        let daughtersShare = 0;
        let fatherShare = 0;
        let motherShare = 0;
        let grandfatherShare = 0;
        let grandmotherShare = 0;
        let brothersShare = 0;
        let sistersShare = 0;
        let remainingShare = netAsset;

        if (deceased === "laki-laki") {
            spouseShare = netAsset / 4; // Suami dapat 1/4 dari istri
            remainingShare -= spouseShare;
            if (numSons > 0 || numDaughters > 0) {
                const childrenShare = remainingShare;
                sonsShare = (childrenShare * 2) / (3 * numSons + numDaughters); // 2 bagian untuk anak laki-laki
                daughtersShare = childrenShare / (3 * numSons + numDaughters); // 1 bagian untuk anak perempuan
                remainingShare -= (sonsShare * numSons + daughtersShare * numDaughters);
            }
            if (parents === "both" || parents === "ayah") {
                fatherShare = remainingShare / 6;
                remainingShare -= fatherShare;
            }
            if (parents === "both" || parents === "ibu") {
                motherShare = remainingShare / 6;
                remainingShare -= motherShare;
            }
            if ((parents === "none") && (grandparents === "kakek" || grandparents === "both")) {
                grandfatherShare = remainingShare / 6;
                remainingShare -= grandfatherShare;
            }
            if ((parents === "none") && (grandparents === "nenek" || grandparents === "both")) {
                grandmotherShare = remainingShare / 6;
                remainingShare -= grandmotherShare;
            }
            if (siblings && (numBrothers > 0 || numSisters > 0)) {
                brothersShare = (remainingShare * numBrothers) / (numBrothers + numSisters);
                sistersShare = (remainingShare * numSisters) / (numBrothers + numSisters);
            }
        } else if (deceased === "perempuan") {
            spouseShare = netAsset / 8; // Istri dapat 1/8 dari suami
            remainingShare -= spouseShare;
            if (numSons > 0 || numDaughters > 0) {
                const childrenShare = remainingShare;
                sonsShare = (childrenShare * 2) / (3 * numSons + numDaughters); // 2 bagian untuk anak laki-laki
                daughtersShare = childrenShare / (3 * numSons + numDaughters); // 1 bagian untuk anak perempuan
                remainingShare -= (sonsShare * numSons + daughtersShare * numDaughters);
            }
            if (parents === "both" || parents === "ayah") {
                fatherShare = remainingShare / 6;
                remainingShare -= fatherShare;
            }
            if (parents === "both" || parents === "ibu") {
                motherShare = remainingShare / 6;
                remainingShare -= motherShare;
            }
            if ((parents === "none") && (grandparents === "kakek" || grandparents === "both")) {
                grandfatherShare = remainingShare / 6;
                remainingShare -= grandfatherShare;
            }
            if ((parents === "none") && (grandparents === "nenek" || grandparents === "both")) {
                grandmotherShare = remainingShare / 6;
                remainingShare -= grandmotherShare;
            }
            if (siblings && (numBrothers > 0 || numSisters > 0)) {
                brothersShare = (remainingShare * numBrothers) / (numBrothers + numSisters);
                sistersShare = (remainingShare * numSisters) / (numBrothers + numSisters);
            }
        }

        let hasilRincian = `
            <tr><td>Tirkah</td><td>${formatToRupiah(totalAsset)}</td></tr>
            <tr><td>Hutang</td><td>${formatToRupiah(debt)}</td></tr>
            <tr><td>Biaya Makam</td><td>${formatToRupiah(tajhiz)}</td></tr>
            <tr><td>Wasiat</td><td>${formatToRupiah(wasiat)}</td></tr>
            <tr><td>Al-Irts</td><td>${formatToRupiah(netAsset)}</td></tr>
            <tr><td>Asal masalah</td><td>4</td></tr>
            <tr><td colspan="2"><strong>WARIST BAGIAN @ORANG</strong></td></tr>
            <tr><td>1 Suami (1/4)</td><td>1/4 ${formatToRupiah(spouseShare)}</td></tr>
        `;

        if (numDaughters > 0) {
            hasilRincian += `<tr><td>2 Anak Perempuan (1:1A)</td><td>3/16 ${formatToRupiah(daughtersShare)}</td></tr>`;
        }
        if (numSons > 0) {
            hasilRincian += `<tr><td>3 Anak Laki-laki (2:1A)</td><td>9/16 ${formatToRupiah(sonsShare)}</td></tr>`;
        }
        if (fatherShare > 0) {
            hasilRincian += `<tr><td>4 Ayah</td><td>1/6 ${formatToRupiah(fatherShare)}</td></tr>`;
        }
        if (motherShare > 0) {
            hasilRincian += `<tr><td>5 Ibu</td><td>1/6 ${formatToRupiah(motherShare)}</td></tr>`;
        }
        if (grandfatherShare > 0) {
            hasilRincian += `<tr><td>6 Kakek</td><td>1/6 ${formatToRupiah(grandfatherShare)}</td></tr>`;
        }
        if (grandmotherShare > 0) {
            hasilRincian += `<tr><td>7 Nenek</td><td>1/6 ${formatToRupiah(grandmotherShare)}</td></tr>`;
        }
        if (brothersShare > 0) {
            hasilRincian += `<tr><td>8 Saudara Laki-laki</td><td>${formatToRupiah(brothersShare)}</td></tr>`;
        }
        if (sistersShare > 0) {
            hasilRincian += `<tr><td>9 Saudara Perempuan</td><td>${formatToRupiah(sistersShare)}</td></tr>`;
        }

        if (remainingShare > 0) {
            if (parents === "ayah") {
                hasilRincian += `<tr><td>10 Sisa Harta (Ashabah untuk Ayah)</td><td>${formatToRupiah(remainingShare)}</td></tr>`;
            } else if (parents === "both") {
                hasilRincian += `<tr><td>10 Sisa Harta (Ashabah untuk Ayah dan Ibu)</td><td>${formatToRupiah(remainingShare)}</td></tr>`;
            }
        }

        hasilTableBody.innerHTML = hasilRincian;
        hasilSection.style.display = "block";
    }

    religionSelect.addEventListener("change", function() {
        deceasedGroup.style.display = religionSelect.value === "Islam" ? "block" : "none";
        resetGroups();
    });

    deceasedSelect.addEventListener("change", function() {
        resetGroups();
        displayGroups(deceasedSelect.value);
    });

    childrenSelect.addEventListener("change", function() {
        const display = childrenSelect.value === "yes" ? "block" : "none";
        numSonsGroup.style.display = display;
        numDaughtersGroup.style.display = display;
    });

    parentsSelect.addEventListener("change", function() {
        const display = (parentsSelect.value === "none") ? "block" : "none";
        grandparentGroup.style.display = display;
    });

    grandparentsSelect.addEventListener("change", function() {
        const display = (grandparentsSelect.value === "none") ? "block" : "none";
        siblingsGroup.style.display = display;
    });

    siblingsSelect.addEventListener("change", function() {
        const display = siblingsSelect.value === "yes" ? "block" : "none";
        numBrothersGroup.style.display = display;
        numSistersGroup.style.display = display;
    });

    totalAssetInput.addEventListener("input", function(e) {
        let value = totalAssetInput.value;
        value = value.replace(/\D/g, ''); // Remove non-digit characters
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        totalAssetInput.value = value;
        calculateInheritance();
    });

    debtInput.addEventListener("input", function(e) {
        let value = debtInput.value;
        value = value.replace(/\D/g, ''); // Remove non-digit characters
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        debtInput.value = value;
        calculateInheritance();
    });

    wasiatInput.addEventListener("input", function(e) {
        let value = wasiatInput.value;
        value = value.replace(/\D/g, ''); // Remove non-digit characters
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        wasiatInput.value = value;
        calculateInheritance();
    });

    tajhizInput.addEventListener("input", function(e) {
        let value = tajhizInput.value;
        value = value.replace(/\D/g, ''); // Remove non-digit characters
        if (value) {
            value = parseInt(value, 10).toLocaleString('id-ID');
        }
        tajhizInput.value = value;
        calculateInheritance();
    });

    calculateButton.addEventListener("click", function() {
        calculateInheritance();
        hasilSection.scrollIntoView({ behavior: "smooth" });
    });

    resetButton.addEventListener("click", function() {
        resetGroups();
        alIrtsInput.value = '';
        hasilSection.style.display = "none";
    });

    recalculateButton.addEventListener("click", function() {
        document.getElementById("warisForm").reset();
        resetGroups();
        alIrtsInput.value = '';
        hasilSection.style.display = "none";
    });

    // Initialize form with previously selected values if available
    if (religionSelect.value === "Islam") {
        deceasedGroup.style.display = "block";
        displayGroups(deceasedSelect.value);
    }
});

</script>
@endpush
