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
                <h1 class="heading" data-aos="fade-up">Cari Peraturan</h1>
                <form id="searchForm" class="narrow-w form-search d-flex align-items-stretch mb-3" data-aos="fade-up" data-aos-delay="200">
                    <input type="text" id="searchInput" class="form-control px-4 autocomplete-input" placeholder="Cari Undang-Undang atau Pasal" data-toggle="tooltip" data-placement="top" title="Silahkan masukkan kata kunci peraturan">
                    <input type="hidden" id="selectedValue" name="selectedValue">
                    <button type="submit" class="btn btn-primary" id="searchButton">Cari</button>
                </form>
                <div id="suggestions" class="autocomplete-suggestions"></div>
            </div>
        </div>
    </div>
  </div>

    <div class="section" id="daftar-peraturan">
        <div class="container">
            <div class="row mb-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="font-weight-bold text-primary heading">
                        Daftar Peraturan
                    </h2>
                </div>        
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="property-slider-wrap">
                        <div class="property-slider">
                            @foreach($data['laws'] as $law)
                                <div class="property-item">
                                    <div class="property-content">
                                        <div class="mb-2">
                                            <br>
                                            <br>
                                            <br>                       
                                            <br>
                                            <h5>{{ $law->name }}</h5>
                                        </div>                    
                                        <div class="row">
                                            <div class="col-12">
                                                <div>                             
                                                    <span class="city d-block mb-1"><strong>Nomor:</strong> {{ $law->nomor }}</span>
                                                    <span class="city d-block mb-1"><strong>Tahun:</strong> {{ $law->tahun }}</span>
                                                    <span class="city d-block mb-1"><strong>Tentang:</strong> {{ $law->tentang }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="#contact-section" class="btn btn-primary py-2 px-3 mt-3">Lihat</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
                            <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">Prev</span>
                            <span class="next" data-controls="next" aria-controls="property" tabindex="-1">Next</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <div class="section" id="detail-uud-section">
        <div class="container">
            <div class="row justify-content-center footer-cta" data-aos="fade-up">
                <div class="col-lg-7 mx-auto text-left">
                    <h2 class="mb-4" style="text-align: center;">Detail Peraturan</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Field</th>
                                <th style="text-align: left;">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['laws'] as $law)
                                <tr>
                                    <td style="text-align: left;">Nama</td>
                                    <td style="text-align: left;">{{ $law->name }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Nomor</td>
                                    <td style="text-align: left;">{{ $law->nomor }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Tahun</td>
                                    <td style="text-align: left;">{{ $law->tahun }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Tentang</td>
                                    <td style="text-align: left;">{{ $law->tentang }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Tanggal Penetapan</td>
                                    <td style="text-align: left;">{{ $law->tanggal_penetapan }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Tanggal Pengundangan</td>
                                    <td style="text-align: left;">{{ $law->tanggal_pengundangan }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Tanggal Berlaku</td>
                                    <td style="text-align: left;">{{ $law->tanggal_berlaku }}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left;">Sumber</td>
                                    <td style="text-align: left;">{{ $law->sumber }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                    <hr style="border: none; border-top: 3px solid #000;">

                    @if($data['pasalDetails'])
                    @foreach($data['pasalDetails'] as $pasalDetail)
                        <div class="pasal-detail" style="text-align: left;">
                            <p style="text-align: center;">Bab {{ $pasalDetail->bab->bab_ke }}<br> {{ $pasalDetail->bab->bab_name }}</p>
                            @if($pasalDetail->bagian)
                                <p style="text-align: center;">Bagian {{ $pasalDetail->bagian->bagian_ke }}<br>{{ $pasalDetail->bagian->bagian_name }}</p>
                            @endif
                            <h4 style="text-align: center;">Pasal {{ $pasalDetail->pasal_ke }}</h4>
                            @if($pasalDetail->pasal_content && strtolower($pasalDetail->pasal_content) !== 'null' && $pasalDetail->pasal_content !== '-')
                                <p style="text-align: left;">{{ $pasalDetail->pasal_content }}</p>
                            @endif
                            @php $numbering = 1; @endphp
                            @foreach($pasalDetail->ayats as $ayat)
                                @if($ayat->ayat_content == '-')
                                    <div style="display: flex; align-items: flex-start;">
                                        <p style="text-align: left; margin-right: 10px;"><strong>{{ $numbering++ }}.</strong></p>
                                        <div style="text-align: left;">
                                            @php $hurufNumbering = 'a'; @endphp
                                            @foreach($ayat->hurufs as $huruf)
                                                <p style="text-align: left;"><strong>{{ $hurufNumbering++ }}. </strong> {{ $huruf->huruf_content }}</p>
                                                @if($huruf->angkas->count() > 0)
                                                    <ul style="text-align: left;">
                                                        @php $angkaNumbering = 1; @endphp
                                                        @foreach($huruf->angkas as $angka)
                                                            <li>{{ $angkaNumbering++ }}. {{ $angka->angka_content }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p style="text-align: left;"><strong>{{ $numbering++ }}. </strong> {{ $ayat->ayat_content }}</p>
                                    @php $hurufNumbering = 'a'; @endphp
                                    @foreach($ayat->hurufs as $huruf)
                                        <p style="text-align: left; margin-left: 20px;"><strong>{{ $hurufNumbering++ }}.</strong> {{ $huruf->huruf_content }}</p>
                                        @if($huruf->angkas->count() > 0)
                                            <ul style="text-align: left; margin-left: 40px;">
                                                @php $angkaNumbering = 1; @endphp
                                                @foreach($huruf->angkas as $angka)
                                                    <li>{{ $angkaNumbering++ }}. {{ $angka->angka_content }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                    {{-- <div id="property-nav" class="controls" tabindex="0" aria-label="Carousel Navigation">
                        <span class="prev" data-controls="prev" aria-controls="property" tabindex="-1">Prev</span>
                        <span class="next" data-controls="next" aria-controls="property" tabindex="-1">Next</span>
                    </div> --}}
                    @endif
    
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
        const suggestions = document.getElementById('suggestions');
        const searchResults = document.getElementById('searchResults');
    
        searchInput.addEventListener('input', function() {
            const query = this.value;
    
            if (query.length > 2) {
                fetch(`/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestions.innerHTML = '';
                        const { laws, articles } = data;
    
                        if (laws.length > 0) {
                            suggestions.innerHTML += '<h5>Undang-Undang</h5>';
                            laws.forEach(law => {
                                suggestions.innerHTML += `<div class="suggestion-item">${law.name} No. ${law.nomor} Tahun ${law.tahun} - ${law.tentang}</div>`;
                            });
                        }
    
                        if (articles.length > 0) {
                            suggestions.innerHTML += '<h5>Pasal</h5>';
                            articles.forEach(article => {
                                const law = article.bab.ruleBUndang;
                                suggestions.innerHTML += `<div class="suggestion-item">${law.name} No. ${law.nomor} Tahun ${law.tahun} - Pasal ${article.pasal_ke}</div>`;
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                suggestions.innerHTML = '';
            }
        });
    
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchInput.value;
    
            fetch(`/search/law?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    const { laws, articles } = data;
    
                    if (laws.length > 0) {
                        searchResults.innerHTML += '<h5>Undang-Undang</h5>';
                        laws.forEach(law => {
                            searchResults.innerHTML += `<div class="result-item">${law.name} No. ${law.nomor} Tahun ${law.tahun} - ${law.tentang}</div>`;
                        });
                    }
    
                    if (articles.length > 0) {
                        searchResults.innerHTML += '<h5>Pasal</h5>';
                        articles.forEach(article => {
                            const law = article.bab.ruleBUndang;
                            searchResults.innerHTML += `<div class="result-item">${law.name} No. ${law.nomor} Tahun ${law.tahun} - Pasal ${article.pasal_ke}</div>`;
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.href;
    const baseUrl = window.location.origin;

    // Pola URL untuk memeriksa apakah URL mengandung tahun
    const urlPatternWithYear = new RegExp(`^${baseUrl}\/kamus\/uu\/\\d+\/\\d{4}(\/.*)?\/?$`);
    const urlPatternWithoutYear = new RegExp(`^${baseUrl}\/kamus\/uu\/\\d+\/?$`);
    const urlPatternBase = new RegExp(`^${baseUrl}\/kamus\/uu\/?$`);

    // Cek jika URL mengandung hash #daftar-peraturan
    if (window.location.hash === '#daftar-peraturan') {
        // Scroll ke elemen dengan id daftar-peraturan
        document.getElementById('daftar-peraturan').scrollIntoView();
    } else {
        if (urlPatternWithYear.test(currentUrl)) {
            document.getElementById('detail-uud-section').style.display = 'block';
            document.getElementById('detail-uud-section').scrollIntoView();
        } else if (urlPatternWithoutYear.test(currentUrl) || urlPatternBase.test(currentUrl)) {
            document.getElementById('detail-uud-section').style.display = 'none';
            document.getElementById('daftar-peraturan').scrollIntoView();
        } else {
            document.getElementById('detail-uud-section').style.display = 'none';
        }
    }
});

</script>

<script>
function showSweetAlert(response) {
  Swal.fire({
      icon: response.success ? 'success' : 'error',
      title: response.title,
      text: response.message,
  });
}

document.addEventListener('DOMContentLoaded', function() {
  @if(session('response'))
      var response = @json(session('response'));
      showSweetAlert(response);
  @endif
});
</script>
@endpush
