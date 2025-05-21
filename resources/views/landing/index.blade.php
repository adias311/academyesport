@extends('layouts.frontend.master')

@section('title', 'Homepage')

@section('hero')
    @include('layouts.frontend._hero')
@endsection

@section('content')
    <div class="container-xl">
        <div class="page-header" id="try">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h2 class="page-title font-weight-bold text-uppercase">
                        All New Series
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($series as $data)
            <div class="col-12 col-lg-4 apa">
                <a class="text-dark" href="{{ route('series.show', $data->slug) }}">
                    <div class="card card-stacked">
                        <div class="ribbon bg-primary {{ $data->updated_at->diffInDays(now()) <= 7 ? '' : 'invisible' }}">New</div>
                        <div class="card-body">
                            <h3 class="card-title text-truncate-1">{{ $data->name }}</h3>
                            <p class="text-muted text-truncate-2">{{ $data->description }}</p>
                            <ul class="list-unstyled">
                                @foreach ($data->tags->take(5) as $tag)
                                    <li class="badge bg-{{ $tag->color }}" style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 1);">
                                        {{ $tag->name }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="d-flex justify-content-between">
                                <div>
                                    {{ $data->videos->filter(fn($video) => !str_contains($video->video_code, 'documents'))->count() }} Episode
                                </div>
                                <div>
                                    Rp. {{ number_format($data->price) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-device-desktop-analytics" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <rect x="3" y="4" width="18" height="12" rx="1"></rect>
                                        <path d="M7 20h10"></path>
                                        <path d="M9 16v4"></path>
                                        <path d="M15 16v4"></path>
                                        <path d="M9 12v-4"></path>
                                        <path d="M12 12v-1"></path>
                                        <path d="M15 12v-2"></path>
                                        <path d="M12 12v-1"></path>
                                    </svg>
                                    {{ $data->level }}
                                </div>
                                <div class="{{ $data->status == 1 ? 'text-teal' : 'text-danger' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-circle-check" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <circle cx="12" cy="12" r="9"></circle>
                                        <path d="M9 12l2 2l4 -4"></path>
                                    </svg>
                                    {{ $data->status == 1 ? 'Completed' : 'Developed' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach           
        </div>        
    </div>

    
        <!-- About Me -->
<section id="about" class="text-light bg-dark">
    <div class="container">
      <h1 class="section-title text-center">About Us</h1>
      <div class="row align-items-center">
        <div class="col-md-6">
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem minima similique, architecto assumenda itaque maiores doloribus illum ullam voluptatem exercitationem ipsam nisi culpa dolorum adipisci earum, provident esse incidunt rem! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo error magni dicta deleniti consequatur qui. Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus consectetur quibusdam repudiandae deleniti! Odit similique vero nobis, magni temporibus autem? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt, quo. Lorem ipsum dolor sit amet consectetur, adipisicing elit. Officiis, illo?</p>
        </div>
        <div class="col-md-6">
          <h3>
            <img src="/vs.svg" alt="" height="64" srcset="">
            Visi
          </h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, optio!</p>
          <h3>
            <img src="/ms.svg" alt="" height="64" srcset="">
            Misi
          </h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia, reiciendis. Minus, pariatur!</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Achievements -->
  <section id="achiev" class="bg-light">
    <div class="container">
      <h1 class="section-title text-center">Achievements</h1>
      <div class="row text-center">
        <div class="col-sm-6 col-lg-3 mb-4">
          <div class="p-4 border rounded">
            <h3 class="h1 text-primary">1st</h3>
            <p>National Championship 2023</p>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
          <div class="p-4 border rounded">
            <h3 class="h1 text-primary">Top 8</h3>
            <p>International Cup 2024</p>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
          <div class="p-4 border rounded">
            <h3 class="h1 text-primary">MVP</h3>
            <p>Regional League 2022</p>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3 mb-4">
          <div class="p-4 border rounded">
            <h3 class="h1 text-primary">Coach of the Year</h3>
            <p>Esport Awards 2024</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Why Join -->
  <section id="why" class="bg-dark text-light">
    <div class="container px-5">
      <h1 class="section-title text-center">Why Join Us</h1>
      <ul class="list-unstyled d-lg-flex justify-content-center">
        <li class="mb-3">        
          <h3>  <img src="/check.png" alt="" srcset="" width="24"> Pelatihan Profesional</h3>
          <p>Materi kurasi langsung dari atlet dan pelatih berpengalaman.</p>
        </li>
        <li class="mb-3">        
          <h3>  <img src="/check.png" alt="" srcset="" width="24"> Pelatihan Profesional</h3>
          <p>Materi kurasi langsung dari atlet dan pelatih berpengalaman.</p>
        </li>
         <li class="mb-3">        
          <h3>  <img src="/check.png" alt="" srcset="" width="24"> Pelatihan Profesional</h3>
          <p>Materi kurasi langsung dari atlet dan pelatih berpengalaman.</p>
        </li>
      </ul>
    </div>
  </section>

  <!-- Testimonials -->
<section id="testi" class="bg-light">
  <div class="container">
    <h1 class="section-title text-center">What They Say About Us</h1>
    <div id="carouselTesti" class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner">
        <div class="carousel-item active text-center">
          <blockquote class="blockquote">
            “Super flexible when it comes to levels!  
            With 3 access levels (beginner, intermediate, advanced) and the ability to access the levels below, users really feel like they’re getting their money’s worth. Newbies aren’t overwhelmed with tough material, and advanced players can jump right into what suits them. That’s what we call smart options!  
            Monthly payment is a breeze: Pay per month means no big upfront cost. And a 50% renewal discount? That totally makes users feel rewarded for sticking around!”
          </blockquote>
          <footer class="blockquote-footer">User 1, <cite>Community Review</cite></footer>
        </div>
        <div class="carousel-item text-center">
          <blockquote class="blockquote">
            “Fair class upgrade system!  
            This is the best part! If you still have active subscription time and want to upgrade your class, the remaining time gets carried over plus you get a discount. That’s a really fair move. Unlike other apps where upgrading feels like wasting your old plan.
            Informative user profile: Showing ‘subs’ status and remaining days in the profile is super helpful. It’s simple, but makes a big difference!”
          </blockquote>
          <footer class="blockquote-footer">User 2, <cite>Beta Tester</cite></footer>
        </div>
        <div class="carousel-item text-center">
          <blockquote class="blockquote">
            “This app’s concept really understands both your wallet and your motivation to learn!  
            The level system prevents you from getting overwhelmed by hard materials or bored with stuff that’s too basic. It makes progress feel smoother and more directed.  
            What I love most is the subscription renewal and class upgrade process. It’s so rare to find an app this fair. Usually, when you upgrade, your previous payment kind of goes to waste — not here. They even extend your time and give a discount. You really feel valued as a user.
            The profile section showing subscription status is also a great feature. You won’t suddenly lose access just because you forgot your payment date.  
            I think this app is perfect for anyone who wants to learn step by step without burning a hole in their pocket. Hope the real product lives up to this concept!”
          </blockquote>
          <footer class="blockquote-footer">User 3, <cite>Early Reviewer</cite></footer>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselTesti" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#carouselTesti" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>
  </div>
</section>


  <!-- Founder -->
  <section id="founder" class="bg-dark text-light">
    <h1 class="section-title text-center">Founder</h1>
    <div class=" d-lg-flex justify-content-center">
      <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
       <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
      <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
      <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
      <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
      <div class="container text-center">
        <img src="/ceo.jpg" alt="Founder" class="founder-img mb-3">
        <h5>Jane Doe</h5>
        <p>Jane adalah mantan pemain pro dengan 8 tahun pengalaman...</p>
      </div>
    </div>
  </section>

<!-- Contact -->
<section id="contact" class="bg-light py-5">
  <div class="container">
    <h1 class="section-title text-center mb-4">Contact Us</h1>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form id="contactForm">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="name">Name</label>
              <input type="text" id="name" class="form-control" placeholder="Your Name" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="email">Email</label>
              <input type="email" id="email" class="form-control" placeholder="you@example.com" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="message">Message</label>
            <textarea id="message" rows="5" class="form-control" placeholder="Write your message here" required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary px-4 mt-3">Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
    <style>      
    :root {
      --azure: #007bff;
      --red:   #dc3545;
    }
    body {
      scroll-behavior: smooth;
    }
    section {
      padding: 100px 0;
    }
    #hero {
      background: url('https://via.placeholder.com/1600x600') center/cover no-repeat;
      color: white;
      text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    }
    h1.section-title {
      color: var(--azure);
      font-weight: 700;
      margin-bottom: 3rem;
    }
    .founder-img {
      width: 150px;
      height: 150px;
      object-fit: cover;     /* KUNCI agar isi gambar tetap proporsional */
      border-radius: 50%;    /* Membuat gambar jadi bulat */
    }

    footer {
      background: #f8f9fa;
      padding: 2rem 0;
    }          

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2; 
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: min-content; 
        }

        .text-truncate-1 {
            white-space: nowrap;      
            overflow: hidden;         
            text-overflow: ellipsis;  
            width: 100%;              
            display: block;           
        }
        
        .card-stacked {
            height: 280px;
        }

        .card-body {
            display: flex !important;
            flex-direction: column; 
            justify-content: space-between; 
        }

        .apa {
            margin-bottom: 1rem; 
        }
       
    </style>    

    <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const name = encodeURIComponent(document.getElementById('name').value.trim());
      const email = encodeURIComponent(document.getElementById('email').value.trim());
      const message = encodeURIComponent(document.getElementById('message').value.trim());

      const phoneNumber = '6289516443037'; // Ganti dengan nomor WA kamu

      const whatsappMessage = `Hello, I would like to get in touch!\n\nName: ${name}\nEmail: ${email}\nMessage: ${message}`;

      window.open(`https://wa.me/${phoneNumber}?text=${whatsappMessage}`, '_blank');
    });
  </script>
@endsection
