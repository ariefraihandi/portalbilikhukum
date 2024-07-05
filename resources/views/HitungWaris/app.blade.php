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
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group mt-3" id="deceasedGroup" style="display: none;">
                        <label for="deceased">Siapa yang meninggal?</label>
                        <select id="deceased" name="deceased" class="form-control px-4" required>
                            <option value="" selected disabled>Pilih Kondisi</option>
                            <option value="suami">Suami</option>
                            <option value="istri">Istri</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="anak">Anak</option>
                            <option value="saudara">Saudara Sekandung</option>
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
                        <input type="number" id="numSons" name="numSons" class="form-control px-4" min="0" required>
                    </div>
                    <div class="form-group mt-3" id="numDaughtersGroup" style="display: none;">
                        <label for="numDaughters">Berapa jumlah anak perempuan?</label>
                        <input type="number" id="numDaughters" name="numDaughters" class="form-control px-4" min="0" required>
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
                        <input type="number" id="numBrothers" name="numBrothers" class="form-control px-4" min="0" required>
                    </div>
                    <div class="form-group mt-3" id="numSistersGroup" style="display: none;">
                        <label for="numSisters">Berapa jumlah saudara perempuan sekandung?</label>
                        <input type="number" id="numSisters" name="numSisters" class="form-control px-4" min="0" required>
                    </div>
                    <button type="button" class="btn btn-primary mt-3" id="calculateButton">Hitung</button>
                    <button type="reset" class="btn btn-secondary mt-3" id="resetButton">Reset</button>
                </form>
                <div id="resultSection" class="mt-4" style="display: none;">
                    <h2>Hasil Pembagian Waris</h2>
                    <table class="table table-bordered">
                        <tr>
                            <th>Suami/Istri</th>
                            <td id="resultSpouse"></td>
                        </tr>
                        <tr>
                            <th>Anak Laki-laki</th>
                            <td id="resultSons"></td>
                        </tr>
                        <tr>
                            <th>Anak Perempuan</th>
                            <td id="resultDaughters"></td>
                        </tr>
                        <tr>
                            <th>Ayah</th>
                            <td id="resultFather"></td>
                        </tr>
                        <tr>
                            <th>Ibu</th>
                            <td id="resultMother"></td>
                        </tr>
                        <tr>
                            <th>Saudara Laki-laki Sekandung</th>
                            <td id="resultBrothers"></td>
                        </tr>
                        <tr>
                            <th>Saudara Perempuan Sekandung</th>
                            <td id="resultSisters"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
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
        const numWivesGroup = document.getElementById("numWivesGroup");
        const childrenGroup = document.getElementById("childrenGroup");
        const numSonsGroup = document.getElementById("numSonsGroup");
        const numDaughtersGroup = document.getElementById("numDaughtersGroup");
        const parentGroup = document.getElementById("parentGroup");
        const siblingsGroup = document.getElementById("siblingsGroup");
        const numBrothersGroup = document.getElementById("numBrothersGroup");
        const numSistersGroup = document.getElementById("numSistersGroup");
        const totalAssetInput = document.getElementById("totalAsset");
        const debtInput = document.getElementById("debt");
        const childrenSelect = document.getElementById("children");
        const deceasedSelect = document.getElementById("deceased");
        const parentsSelect = document.getElementById("parents");
        const siblingsSelect = document.getElementById("siblings");
        const calculateButton = document.getElementById("calculateButton");
        const resetButton = document.getElementById("resetButton");

        const resultSection = document.getElementById("resultSection");
        const resultSpouse = document.getElementById("resultSpouse");
        const resultSons = document.getElementById("resultSons");
        const resultDaughters = document.getElementById("resultDaughters");
        const resultFather = document.getElementById("resultFather");
        const resultMother = document.getElementById("resultMother");
        const resultBrothers = document.getElementById("resultBrothers");
        const resultSisters = document.getElementById("resultSisters");

        function resetGroups() {
            totalAssetGroup.style.display = "none";
            debtGroup.style.display = "none";
            numWivesGroup.style.display = "none";
            childrenGroup.style.display = "none";
            numSonsGroup.style.display = "none";
            numDaughtersGroup.style.display = "none";
            parentGroup.style.display = "none";
            siblingsGroup.style.display = "none";
            numBrothersGroup.style.display = "none";
            numSistersGroup.style.display = "none";
        }

        function displayGroups(deceasedValue) {
            totalAssetGroup.style.display = "block";
            debtGroup.style.display = "block";
            switch (deceasedValue) {
                case "suami":
                    numWivesGroup.style.display = "block";
                    childrenGroup.style.display = "block";
                    parentGroup.style.display = "block";
                    siblingsGroup.style.display = "block";
                    break;
                case "istri":
                    childrenGroup.style.display = "block";
                    parentGroup.style.display = "block";
                    break;
                case "ayah":
                case "ibu":
                    childrenGroup.style.display = "block";
                    siblingsGroup.style.display = "block";
                    break;
                case "anak":
                    parentGroup.style.display = "block";
                    break;
                case "saudara":
                    parentGroup.style.display = "block";
                    siblingsGroup.style.display = "block";
                    break;
            }
        }

        function formatToRupiah(value) {
            return 'Rp ' + value.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        }

        function calculateInheritance() {
            const totalAsset = parseInt(totalAssetInput.value.replace(/\D/g, ''), 10);
            const debt = parseInt(debtInput.value.replace(/\D/g, ''), 10);
            const netAsset = totalAsset - debt;
            const deceased = deceasedSelect.value;
            const numWives = parseInt(document.getElementById("numWives").value, 10) || 0;
            const numSons = parseInt(document.getElementById("numSons").value, 10) || 0;
            const numDaughters = parseInt(document.getElementById("numDaughters").value, 10) || 0;
            const parents = parentsSelect.value;
            const siblings = siblingsSelect.value === "yes";
            const numBrothers = parseInt(document.getElementById("numBrothers").value, 10) || 0;
            const numSisters = parseInt(document.getElementById("numSisters").value, 10) || 0;

            let spouseShare = 0;
            let sonsShare = 0;
            let daughtersShare = 0;
            let fatherShare = 0;
            let motherShare = 0;
            let brothersShare = 0;
            let sistersShare = 0;

            if (deceased === "suami") {
                spouseShare = netAsset / (numWives * 8); // Istri dapat 1/8 dari suami
                if (numSons > 0 || numDaughters > 0) {
                    const childrenShare = netAsset - spouseShare;
                    sonsShare = (childrenShare * 2) / (3 * numSons + numDaughters); // 2 bagian untuk anak laki-laki
                    daughtersShare = childrenShare / (3 * numSons + numDaughters); // 1 bagian untuk anak perempuan
                } else if (parents === "both") {
                    fatherShare = netAsset / 6;
                    motherShare = netAsset / 6;
                } else if (parents === "ayah") {
                    fatherShare = netAsset / 6;
                } else if (parents === "ibu") {
                    motherShare = netAsset / 6;
                } else {
                    const remainingShare = netAsset - spouseShare;
                    if (siblings && (numBrothers + numSisters) > 0) {
                        brothersShare = remainingShare / (numBrothers + numSisters);
                        sistersShare = brothersShare; // saudara kandung dapat sisa
                    }
                }
            } else if (deceased === "istri") {
                spouseShare = netAsset / 4; // Suami dapat 1/4 dari istri
                if (numSons > 0 || numDaughters > 0) {
                    const childrenShare = netAsset - spouseShare;
                    sonsShare = (childrenShare * 2) / (3 * numSons + numDaughters); // 2 bagian untuk anak laki-laki
                    daughtersShare = childrenShare / (3 * numSons + numDaughters); // 1 bagian untuk anak perempuan
                } else if (parents === "both") {
                    fatherShare = netAsset / 6;
                    motherShare = netAsset / 6;
                } else if (parents === "ayah") {
                    fatherShare = netAsset / 6;
                } else if (parents === "ibu") {
                    motherShare = netAsset / 6;
                } else {
                    const remainingShare = netAsset - spouseShare;
                    if (siblings && (numBrothers + numSisters) > 0) {
                        brothersShare = remainingShare / (numBrothers + numSisters);
                        sistersShare = brothersShare; // saudara kandung dapat sisa
                    }
                }
            }

            resultSpouse.innerText = formatToRupiah(Math.floor(spouseShare));
            resultSons.innerText = formatToRupiah(Math.floor(sonsShare));
            resultDaughters.innerText = formatToRupiah(Math.floor(daughtersShare));
            resultFather.innerText = formatToRupiah(Math.floor(fatherShare));
            resultMother.innerText = formatToRupiah(Math.floor(motherShare));
            resultBrothers.innerText = formatToRupiah(Math.floor(brothersShare));
            resultSisters.innerText = formatToRupiah(Math.floor(sistersShare));

            resultSection.style.display = "block";
            resultSection.scrollIntoView({ behavior: "smooth" });
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
        });

        debtInput.addEventListener("input", function(e) {
            let value = debtInput.value;
            value = value.replace(/\D/g, ''); // Remove non-digit characters
            if (value) {
                value = parseInt(value, 10).toLocaleString('id-ID');
            }
            debtInput.value = value;
        });

        calculateButton.addEventListener("click", calculateInheritance);

        resetButton.addEventListener("click", function() {
            resetGroups();
            resultSection.style.display = "none";
        });

        // Initialize form with previously selected values if available
        if (religionSelect.value === "Islam") {
            deceasedGroup.style.display = "block";
            displayGroups(deceasedSelect.value);
        }
    });
</script>
@endpush
