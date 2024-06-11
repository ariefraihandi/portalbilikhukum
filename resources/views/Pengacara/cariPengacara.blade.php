@extends('Pengacara/Index/app')
@section('content')
<div class="hero">
    <div class="hero-slide">
      <div class="img overlay" style="background-image: url('{{ asset('assets/index/assets') }}/images/hero_bg_5.webp')" alt="Pengacara profesional di bilikhukum.com"></div>
      <div class="img overlay" style="background-image: url('{{ asset('assets/index/assets') }}/images/hero_bg_4.webp')" alt="Konsultasi hukum terpercaya di bilikhukum.com"></div>
      <div class="img overlay" style="background-image: url('{{ asset('assets/index/assets') }}/images/hero_bg_3.webp')" alt="Layanan hukum cepat dan mudah di bilikhukum.com"></div>
      <div class="img overlay" style="background-image: url('{{ asset('assets/index/assets') }}/images/hero_bg_2.webp')" alt="Jasa pengacara handal di bilikhukum.com"></div>
      <div class="img overlay" style="background-image: url('{{ asset('assets/index/assets') }}/images/hero_bg_1.webp')" alt="Temukan pengacara terbaik di bilikhukum.com"></div>      
    </div>

    <div class="container">
      <div class="row justify-content-center align-items-center">
          <div class="col-lg-9 text-center">
              <h1 class="heading" data-aos="fade-up">Cari Pengacara Terbaik Di Sekitar Anda</h1>
              <form id="searchForm" class="narrow-w form-search d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
                  <input type="text" id="searchInput" class="form-control px-4 autocomplete-input" placeholder="Provinsi Atau Kabupaten/Kota" data-toggle="tooltip" data-placement="top" title="Silahkan Pilih Opsi Wilayah Yang Ditawarkan">
                  <input type="hidden" id="selectedValue" name="selectedValue">
                  <button type="submit" class="btn btn-primary" id="searchButton">Cari</button>
              </form>
          </div>
      </div>
  </div> 
  </div>

  <div class="section" id="pengacara-rekomendasi">
    <div class="container">
      <div class="row mb-5 align-items-center">
        <div class="col-lg-6">
          <h2 class="font-weight-bold text-primary heading">
            Daftar Pengacara
          </h2>
        </div>        
      </div>
      <div class="row">
        <div class="col-12">
          <div class="property-slider-wrap">
            <div class="property-slider">
              {{-- <div class="property-item">
                <a href="property-single.html" class="img">
                  <img src="{{ asset('assets/index/assets') }}/images/img_1.jpg" alt="Image" class="img-fluid" />
                </a>

                <div class="property-content">
                  <div class="price mb-2"><span>$1,291,000</span></div>
                  <div class="rate">
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                    <span class="icon-star text-warning"></span>
                  </div>
                  <div>
                    <span class="d-block mb-2 text-black-50"
                      >5232 California Fake, Ave. 21BC</span
                    >
                    <span class="city d-block mb-3">California, USA</span>

                    <div class="specs d-flex mb-4">
                      <span class="d-block d-flex align-items-center me-3">
                        <span class="icon-bed me-2"></span>
                        <span class="caption">2 beds</span>
                      </span>
                      <span class="d-block d-flex align-items-center">
                        <span class="icon-bath me-2"></span>
                        <span class="caption">2 baths</span>
                      </span>
                    </div>

                    <a
                      href="property-single.html"
                      class="btn btn-primary py-2 px-3"
                      >See details</a
                    >
                  </div>
                </div>
              </div> --}}
              <!-- .item -->

              @foreach($data['offices'] as $office)
                <div class="property-item">
                    <a href="property-single.html" class="img">
                        <img src="{{ asset('assets/img/member') }}/{{ $office->user->image }}" alt="Image" class="img-fluid" />
                    </a>
                    <div class="property-content">
                        <div class="price mb-2"><span>{{ $office->nama_kantor }}</span></div>
                        <div class="rate">
                            @for ($i = 0; $i < $office->label_count; $i++)
                                <span class="icon-dollar text-warning"></span>
                            @endfor
                        </div>
                        <div>
                            <span class="d-block mb-2 text-black-50">{{ $office->alamat }}, {{ $office->village->name }}</span>
                            <span class="city d-block mb-3">{{ $office->regency->name }}, {{ $office->province->name }}</span>
                            <a href="#" class="btn btn-primary py-2 px-3 consult-btn" data-office-id="{{ $office->id }}" data-office-name="{{ $office->nama_kantor }}" data-office-address="{{ $office->alamat }}" data-office-village="{{ $office->village->name }}" data-office-regency="{{ $office->regency->name }}" data-office-province="{{ $office->province->name }}">Konsultasi Gratis</a>
                        </div>
                    </div>
                </div>
              @endforeach
              {{-- @foreach($data['offices'] as $office)
                <div class="property-item">
                  <a href="property-single.html" class="img">
                    <img src="{{ asset('assets/img/member') }}/{{ $office->user->image }}" alt="Image" class="img-fluid" />
                  </a>
                  <div class="property-content">
                    <div class="price mb-2"><span>{{$office->nama_kantor}}</span></div>
                    <div class="rate">
                      <span class="icon-star text-warning"></span>
                      <span class="icon-star text-warning"></span>
                      <span class="icon-star text-warning"></span>
                      <span class="icon-star text-warning"></span>
                      <span class="icon-star text-warning"></span>
                    </div>
                    <div>
                      <span class="d-block mb-2 text-black-50">{{ $office->alamat}}, {{ $office->village->name}}</span
                      >
                      <span class="city d-block mb-3">{{ $office->regency->name}}, {{ $office->province->name}}</span>

                      <div class="specs d-flex mb-4">
                        <span class="d-block d-flex align-items-center me-3">
                          <span class="icon-bed me-2"></span>
                          <span class="caption">2 beds</span>
                        </span>
                        <span class="d-block d-flex align-items-center">
                          <span class="icon-bath me-2"></span>
                          <span class="caption">2 baths</span>
                        </span>
                      </div>

                      <a
                        href="property-single.html"
                        class="btn btn-primary py-2 px-3"
                        >Konsultasi Gratis</a
                      >
                    </div>
                  </div>
                </div>
              @endforeach --}}
            </div>

            <div
              id="property-nav"
              class="controls"
              tabindex="0"
              aria-label="Carousel Navigation"
            >
              <span
                class="prev"
                data-controls="prev"
                aria-controls="property"
                tabindex="-1"
                >Prev</span
              >
              <span
                class="next"
                data-controls="next"
                aria-controls="property"
                tabindex="-1"
                >Next</span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section section-properties" id="pengacara-disekitar">
    <div class="container">
        <div class="row mb-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="font-weight-bold text-primary heading">
                    Daftar Pengacara Di <span id="namaDaerah">[Nama Daerah]</span>
                </h2>
            </div>
            <div class="col-lg-6 text-lg-end">
                <p>
                    <a href="#" id="filterButton" class="btn btn-primary text-white py-3 px-4">Opsi Filter</a>
                </p>
            </div>
        </div>
        <div class="row" id="officeResults">
            <!-- Results will be injected here -->
        </div>
    </div>
  </div>

  <div class="section" id="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info">
                      <div id="selected-office-info">                        
                        <h3 id="office-name"></h3>
                        
                        
                     
                        
                    </div>
                    <div class="address mt-2">
                        <i class="icon-room"></i>
                        <h4 class="mb-2">Alamat:</h4>
                        <p id="office-address"></p>
                    </div>
                    <div class="open-hours mt-4">
                        <i class="icon-clock-o"></i>
                        <h4 class="mb-2">Open Hours:</h4>
                        <p>Senin-Jumat:<br />08:00 AM - 05.00 PM</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <form action="#" id="contact-form">
                    <input type="hidden" id="office-id" name="office-id" value="">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <input type="text" class="form-control" placeholder="Your Name" />
                        </div>
                        <div class="col-6 mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" />
                        </div>
                        <div class="col-12 mb-3">
                            <input type="text" class="form-control" placeholder="Subject" />
                        </div>
                        <div class="col-12 mb-3">
                            <textarea name="" id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                        </div>
                        <div class="col-12">
                            <input type="submit" value="Send Message" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

  <div class="section">
    <div class="row justify-content-center footer-cta" data-aos="fade-up">
      <div class="col-lg-7 mx-auto text-center">
        <h2 class="mb-4">Jadilah Bagian dari Bilikhukum</h2>
        <p>
          <a
            href="{{ route('join') }}/?token=3wnY0chj"
            target="_blank"
            class="btn btn-primary text-white py-3 px-4"
            >Daftar Sekarang</a
          >
        </p>
      </div>
      <!-- /.col-lg-7 -->
    </div>
    <!-- /.row -->
  </div>

  
@endsection

@push('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const selectedValue = document.getElementById('selectedValue');
    const searchForm = document.getElementById('searchForm');
    const namaDaerah = document.getElementById('namaDaerah');
    const filterButton = document.getElementById('filterButton');

    $(searchInput).tooltip({ trigger: 'manual' });

    searchInput.addEventListener('input', function() {
        if (searchInput.value.length === 0) {
            selectedValue.value = '';
        }
    });

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        if (!selectedValue.value) {
            $(searchInput).tooltip('show');
        } else {
            $(searchInput).tooltip('hide');
            fetchResults();
        }
    });

    function fetchResults() {
        console.log({ selectedValue: selectedValue.value });

        $.ajax({
            url: '{{ route("search-offices") }}',
            type: 'GET',
            dataType: 'json',
            data: {
                selectedValue: selectedValue.value
            },
            success: function(data) {
                console.log(data);

                const kode = selectedValue.value;

                fetch(`/location/${kode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.name) {
                            console.log('Nama Daerah:', data.name);
                            namaDaerah.textContent = data.name; // Set the selected city/province name
                        } else {
                            console.error(data.error);
                            namaDaerah.textContent = 'Nama daerah tidak ditemukan'; // Fallback if name is not found
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        namaDaerah.textContent = 'Terjadi kesalahan'; // Fallback if there's an error
                    });

                renderResults(data);
                $('html, body').animate({
                    scrollTop: $('#pengacara-disekitar').offset().top
                }, 400);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function renderResults(data) {
    const resultsContainer = document.getElementById('officeResults');
    resultsContainer.innerHTML = '';
    if (data.length > 0) {
        document.getElementById('pengacara-disekitar').style.display = 'block';
        data.forEach(function(office) {
            let dollarSigns = '';
            for (let i = 0; i < office.label_count; i++) {
                dollarSigns += `<span class="icon-dollar text-warning"></span>`;
            }

            const officeHtml = `
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="property-item mb-30">
                        <a href="property-single.html" class="img">
                            <img src="/assets/img/member/${office.user.image}" alt="Image" class="img-fluid" />
                        </a>
                        <div class="property-content">
                            <div class="price mb-2"><span>${office.nama_kantor}</span></div>
                            <div class="rate">
                                ${dollarSigns}
                            </div>
                            <div>
                                <span class="d-block mb-2 text-black-50">${office.alamat}, ${office.village.name}</span>
                                <span class="city d-block mb-3">${office.regency.name}, ${office.province.name}</span>
                                <a href="#" class="btn btn-primary py-2 px-3 consult-btn" data-office-id="${office.id}" data-office-name="${office.nama_kantor}" data-office-address="${office.alamat}" data-office-village="${office.village.name}" data-office-regency="${office.regency.name}" data-office-province="${office.province.name}">Konsultasi Gratis</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            resultsContainer.insertAdjacentHTML('beforeend', officeHtml);
        });

        // Reattach event listeners for the new "Konsultasi Gratis" buttons
        attachConsultButtonListeners();
    } else {
        document.getElementById('pengacara-disekitar').style.display = 'none';
    }
}

function attachConsultButtonListeners() {
    var consultButtons = document.querySelectorAll('.consult-btn');
    var contactSection = document.getElementById('contact-section');
    var officeIdInput = document.getElementById('office-id');

    var officeName = document.getElementById('office-name');
    var officeAddress = document.getElementById('office-address');
    var officeVillage = document.getElementById('office-village');
    var officeRegency = document.getElementById('office-regency');
    var officeProvince = document.getElementById('office-province');

    consultButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            var officeId = button.getAttribute('data-office-id');
            officeIdInput.value = officeId;

            // Set the office details
            officeName.innerText = "Hubungi: " + button.getAttribute('data-office-name');
            officeAddress.innerText = button.getAttribute('data-office-address') + ", " + button.getAttribute('data-office-village') + ", " + button.getAttribute('data-office-regency') + ", " + button.getAttribute('data-office-province');

            contactSection.style.display = 'block';

            // Smooth scroll to the contact section
            contactSection.scrollIntoView({ behavior: 'smooth' });
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    attachConsultButtonListeners();
});


    $("#searchInput").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '{{ route("search") }}',
                type: 'GET',
                dataType: 'json',
                data: {
                    search: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value
                        };
                    }));
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            $("#selectedValue").val(ui.item.value);
            searchInput.value = ui.item.label;
            $(searchInput).tooltip('hide');
            return false;
        }
    });

    // Add functionality for the filter button
    filterButton.addEventListener('click', function() {
        // Add your filter logic here
        alert('Filter options coming soon!');
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
        var consultButtons = document.querySelectorAll('.consult-btn');
        var contactSection = document.getElementById('contact-section');
        var officeIdInput = document.getElementById('office-id');

        var officeName = document.getElementById('office-name');
        var officeAddress = document.getElementById('office-address');
        var officeVillage = document.getElementById('office-village');
        var officeRegency = document.getElementById('office-regency');
        var officeProvince = document.getElementById('office-province');

        consultButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                var officeId = button.getAttribute('data-office-id');
                officeIdInput.value = officeId;

                // Set the office details
                officeName.innerText = "Hubungi: " + button.getAttribute('data-office-name');
                officeAddress.innerText = button.getAttribute('data-office-address')+", "+ button.getAttribute('data-office-village')+", "+ button.getAttribute('data-office-regency')+", "+ button.getAttribute('data-office-province');

                contactSection.style.display = 'block';

                // Smooth scroll to the contact section
                contactSection.scrollIntoView({ behavior: 'smooth' });
            });
        });
    });
</script>
@endpush
