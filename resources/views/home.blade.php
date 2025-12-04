@extends('layouts.app')

@section('title', 'Propsgh | Real Estate - Homepage')
@section('meta_description', 'Finder - Directory & Listings Bootstrap HTML Template')

@section('content')
<main class="content-wrapper">

  <!-- Hero with search form -->
  <section class="position-relative mt-md-5">
    <div class="container position-relative z-1 pt-5 pt-md-4 pt-xl-5">
      <div class="row pt-lg-3 pt-xl-0 pt-xxl-4 pb-4 pb-md-5 pb-xl-0">
        <div class="col-md-6 col-xxl-5 text-center text-md-start">
          <h1 class="display-4 pb-sm-1 pb-lg-3">Easy way to find a perfect property</h1>
          <p class="fs-lg mb-md-0">We provide a complete service for the sale, purchase or rental of real estate.</p>
        </div>
      </div>
      <div class="d-none d-md-block d-lg-none" style="height: 70px"></div>
      <div class="d-none d-lg-block d-xl-none" style="height: 130px"></div>
      <div class="d-none d-xl-block" style="height: 220px"></div>

      <!-- Search form -->
      <div class="row pb-5 pb-md-0">
        <div class="col-xl-10 col-xxl-9">
          <form class="bg-body border rounded-4 p-2">
            <div class="row g-0 p-1">
              <div class="col-lg-7">
                <div class="row g-0">
                  <div class="col-6 col-md-4 d-flex">
                    <div class="w-100">
                      <select class="form-select form-select-lg border-0 ps-3" aria-label="Rent or sale select" required>
                        <option value="For rent">For rent</option>
                        <option value="For sale">For sale</option>
                      </select>
                    </div>
                    <hr class="vr m-0">
                  </div>
                  <div class="col-6 col-md-4 d-flex">
                    <div class="w-100">
                      <select class="form-select form-select-lg border-0" aria-label="Location select" required>
                        <option value="">Location</option>
                        <option value="New York">New York</option>
                        <option value="Los Angeles">Los Angeles</option>
                        <option value="Chicago">Chicago</option>
                        <option value="Houston">Houston</option>
                        <option value="Phoenix">Phoenix</option>
                        <option value="Philadelphia">Philadelphia</option>
                        <option value="San Antonio">San Antonio</option>
                        <option value="San Diego">San Diego</option>
                        <option value="Dallas">Dallas</option>
                        <option value="San Jose">San Jose</option>
                      </select>
                    </div>
                    <hr class="vr d-none d-md-block m-0">
                  </div>
                  <div class="col-md-4 d-flex">
                    <div class="w-100">
                      <hr class="d-md-none my-2">
                      <select class="form-select form-select-lg border-0 ps-3" aria-label="Property type select" required>
                        <option value="">Property type</option>
                        <option value="Houses">Houses</option>
                        <option value="Apartments">Apartments</option>
                        <option value="Commercial">Commercial</option>
                        <option value="Daily rental">Daily rental</option>
                        <option value="Offices">Offices</option>
                        <option value="Townhouses">Townhouses</option>
                      </select>
                    </div>
                    <hr class="vr d-none d-lg-block m-0">
                  </div>
                </div>
              </div>
              <hr class="d-lg-none mt-2 mb-0">
              <div class="col-lg-5 d-flex flex-column flex-sm-row align-items-sm-center gap-2 gap-sm-3 pt-3 pt-lg-0 ps-lg-3">
                <div class="d-flex align-items-center w-100 gap-2 ps-2 ps-lg-0">
                  Price
                  <div class="range-slider w-100">
                    <div class="range-slider-ui my-4"></div>
                  </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary">
                  Search
                  <i class="fi-search fs-lg ms-2 me-n1"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="d-none d-md-block d-lg-none" style="height: 60px"></div>
      <div class="d-none d-lg-block d-xxl-none" style="height: 90px"></div>
      <div class="d-none d-xxl-block" style="height: 130px"></div>
    </div>

    <!-- Background images -->
    <span class="position-absolute top-0 start-0 w-100 h-100 bg-body-tertiary d-md-none"></span>
    <div class="position-absolute top-0 start-0 w-100 h-100 overflow-hidden mt-xxl-4 d-none d-md-block">
      <div class="position-absolute top-0 start-50 translate-middle-x d-flex gap-4" style="width: 1560px">
        <div style="width: 768px">
          <div class="d-xl-none" style="height: 295px"></div>
          <div class="d-none d-xl-block d-xxl-none" style="height: 326px"></div>
          <div class="d-none d-xxl-block" style="height: 366px"></div>
          <div class="position-relative overflow-hidden">
            <div class="position-absolute top-0 z-1 fw-bold" style="right: 0; margin: -75px 96px 0 0; font-size: 128px; color: var(--fn-body-bg)">Buy</div>
            <div class="ratio bg-body-tertiary rounded overflow-hidden" style="--fn-aspect-ratio: calc(328 / 768 * 100%)">
              <img src="{{ asset('assets/img/home/real-estate/hero/01.jpg') }}" alt="Image">
            </div>
          </div>
        </div>
        <div style="width: 306px">
          <div class="position-relative overflow-hidden">
            <div class="position-absolute top-0 z-1 fw-bold" style="left: 0; margin: -10px 0 0 -69px; font-size: 128px; color: var(--fn-body-bg); writing-mode: vertical-rl; text-orientation: mixed; transform: rotate(-180deg)">Sell</div>
            <div class="ratio bg-info rounded overflow-hidden" style="--fn-aspect-ratio: calc(443 / 306 * 100%)">
              <img src="{{ asset('assets/img/home/real-estate/hero/02.png') }}" alt="Image">
            </div>
          </div>
        </div>
        <div style="width: 438px">
          <div style="height: 117px"></div>
          <div class="position-relative overflow-hidden">
            <div class="position-absolute top-0 z-1 fw-bold" style="left: 0; margin: -73px 0 0 -18px; font-size: 128px; color: var(--fn-body-bg)">Rent</div>
            <div class="ratio bg-body-tertiary rounded overflow-hidden" style="--fn-aspect-ratio: calc(446 / 438 * 100%)">
              <img src="{{ asset('assets/img/home/real-estate/hero/03.jpg') }}" alt="Image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Categories -->
  <section class="container pt-2 pt-sm-3 pt-md-4 pt-lg-5 my-xxl-3">
    <div class="py-5">
      <div class="border rounded py-3 py-xl-4">
        <div class="row row-cols-2 row-cols-md-3 row-cols-xl-6 g-0 py-2">
          <div class="col d-flex position-relative py-2">
            <div class="vstack align-items-center text-center py-2 px-3">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#!">Houses</a>
              </h3>
              <div class="d-flex align-items-center gap-1 fs-sm">
                <i class="fi-bookmark fs-base"></i>
                6.4K offers
              </div>
            </div>
            <hr class="vr m-0">
          </div>
          <div class="col d-flex position-relative py-2">
            <div class="vstack align-items-center text-center py-2 px-3">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#!">Apartments</a>
              </h3>
              <div class="d-flex align-items-center gap-1 fs-sm">
                <i class="fi-bookmark fs-base"></i>
                12.8K offers
              </div>
            </div>
            <hr class="vr d-none d-md-block m-0">
          </div>
          <div class="col d-flex position-relative py-2">
            <div class="vstack align-items-center text-center py-2 px-3">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#!">Commercial</a>
              </h3>
              <div class="d-flex align-items-center gap-1 fs-sm">
                <i class="fi-bookmark fs-base"></i>
                9.3K offers
              </div>
            </div>
            <hr class="vr d-md-none d-xl-block m-0">
          </div>
          <div class="col d-flex position-relative py-2">
            <div class="vstack align-items-center text-center py-2 px-3">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#!">Daily rental</a>
              </h3>
              <div class="d-flex align-items-center gap-1 fs-sm">
                <i class="fi-bookmark fs-base"></i>
                42.4K offers
              </div>
            </div>
            <hr class="vr d-none d-md-block m-0">
          </div>
          <div class="col d-flex position-relative py-2">
            <div class="vstack align-items-center text-center py-2 px-3">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#!">New buildings</a>
              </h3>
              <div class="d-flex align-items-center gap-1 fs-sm">
                <i class="fi-bookmark fs-base"></i>
                22.5K offers
              </div>
            </div>
            <hr class="vr m-0">
          </div>
          <div class="col d-flex position-relative py-2">
            <div class="vstack dropdown align-items-center text-center py-2 px-3" data-bs-toggle="dropdown" data-bs-display="static">
              <h3 class="h5 mb-2">
                <a class="hover-effect-underline stretched-link" href="#">More</a>
              </h3>
              <div class="d-flex align-items-center fs-sm text-body-emphasis">
                <i class="fi-chevron-down fs-xl"></i>
              </div>
              <ul class="dropdown-menu top-100 start-50 translate-middle-x" style="--fn-dropdown-min-width: 11rem">
                <li><a class="dropdown-item" href="#">Offices</a></li>
                <li><a class="dropdown-item" href="#">Warehouses</a></li>
                <li><a class="dropdown-item" href="#">Retail spaces</a></li>
                <li><a class="dropdown-item" href="#">Townhouses</a></li>
                <li><a class="dropdown-item" href="#">Vacation homes</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- Action cards -->
  <section class="container pt-2 pt-sm-3 pt-md-4 pt-lg-5 my-xxl-3">
    <div class="swiper pb-5" data-swiper='{"slidesPerView":1,"spaceBetween":24,"pagination":{"el":".swiper-pagination","clickable":true},"breakpoints":{"500":{"slidesPerView":2},"768":{"slidesPerView":3}}}'>
      <div class="swiper-wrapper">

        <!-- Buy card -->
        <div class="swiper-slide">
          <article class="card hover-effect-scale bg-primary-subtle border-0 overflow-hidden text-center">
            <div class="card-body pt-sm-5 pb-3">
              <svg class="text-dark-emphasis my-3 mt-sm-0" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"><path d="M43.777.231H3.73C1.673.231 0 1.905 0 3.961v22.548c0 2.057 1.673 3.73 3.73 3.73h9.225a.941.941 0 1 0 0-1.882H3.73a1.85 1.85 0 0 1-1.847-1.847V3.961A1.85 1.85 0 0 1 3.73 2.114h40.048a1.85 1.85 0 0 1 1.847 1.847v22.548a1.85 1.85 0 0 1-1.847 1.847h-2.826a.941.941 0 1 0 0 1.882h2.826c2.057 0 3.73-1.673 3.73-3.73V3.961c0-2.056-1.673-3.73-3.73-3.73zm4.22 34.579a1.81 1.81 0 0 0-1.185-1.647h0l-15.567-5.775a2.81 2.81 0 0 0-3.653 3.653l5.761 15.541a1.81 1.81 0 0 0 1.655 1.186l.052.001a1.81 1.81 0 0 0 1.666-1.093l1.593-3.658 3.455 3.456c.983.984 2.584.984 3.567.001l1.333-1.332c.476-.476.739-1.11.739-1.784a2.51 2.51 0 0 0-.738-1.784l-3.411-3.412 3.658-1.633a1.81 1.81 0 0 0 1.077-1.72zm-6.751 2.191a.94.94 0 0 0-.282 1.525l4.378 4.379a.64.64 0 0 1 0 .905l-1.333 1.332c-.121.121-.282.187-.452.187h0a.64.64 0 0 1-.453-.187l-4.431-4.433a.94.94 0 0 0-1.529.29l-2.082 4.781-5.706-15.394c-.198-.535.119-.91.221-1.012.079-.079.319-.285.67-.285a.98.98 0 0 1 .342.064l15.422 5.721-4.765 2.127zm4.911-2.073l.327-.883-.327.883zm-19.352-9.664l-2.659-2.66a.941.941 0 1 0-1.331 1.331l2.66 2.66a.94.94 0 1 0 1.331-1.331zm-2.606 3.1h-3.761a.941.941 0 1 0 0 1.882h3.761a.941.941 0 1 0 0-1.882zm5.398-9.161a.94.94 0 0 0-.941.941v3.761a.941.941 0 1 0 1.882 0v-3.761a.94.94 0 0 0-.941-.941zm7.9 1.748a.94.94 0 0 0-1.331 0l-2.66 2.66a.94.94 0 1 0 1.332 1.331l2.66-2.66a.94.94 0 0 0 0-1.331zM25.716 32.736a.94.94 0 0 0-1.331 0l-2.66 2.66a.94.94 0 1 0 1.331 1.331l2.66-2.66a.94.94 0 0 0 0-1.331zm-9.026-2.495c.521 0 .944-.423.944-.944s-.423-.944-.944-.944-.944.423-.944.944.423.944.944.944zm-.166-16.121c.825-.358 1.323-1.198 1.323-2.475 0-2.21-1.51-2.739-3.128-2.739h-3.004c-.451 0-.887.218-.887.638V19.66c0 .327.342.623.887.623h3.299c1.759 0 3.112-.872 3.112-3.299v-.327c0-1.556-.654-2.163-1.603-2.537zm-3.688-3.439h1.727c.794 0 1.261.498 1.261 1.307 0 .794-.405 1.338-1.245 1.338h-1.743v-2.645zm3.268 6.132c0 1.183-.56 1.696-1.51 1.696h-1.758v-3.595h1.758c.949 0 1.51.436 1.51 1.65v.249zm9.882-7.906c-.514 0-1.012.187-1.012.623v7.283c0 1.214-.638 1.79-1.712 1.79s-1.712-.576-1.712-1.79V9.529c0-.436-.514-.623-1.012-.623-.514 0-1.012.187-1.012.623v7.283c0 2.599 1.634 3.564 3.735 3.564 2.085 0 3.735-.965 3.735-3.564V9.529c0-.436-.514-.623-1.011-.623zm9.352 0c-.327 0-.467.14-.607.405L32.35 13.81l-2.366-4.498c-.14-.28-.296-.405-.623-.405-.545 0-1.338.342-1.338.84a.61.61 0 0 0 .047.202l3.221 5.571a.39.39 0 0 1 .047.202v3.922c0 .42.514.638 1.012.638.514 0 1.012-.218 1.012-.638v-3.922a.39.39 0 0 1 .062-.202l3.206-5.571c.047-.078.047-.156.047-.202 0-.498-.794-.84-1.338-.84z"></path></svg>
              <h3 class="h5 mb-0">Buy a property</h3>
            </div>
            <div class="card-footer d-flex flex-column align-items-center gap-4 gap-sm-5 bg-transparent border-0 p-0">
              <a class="btn btn-dark stretched-link mx-4" href="#!">Find a home</a>
              <div class="ratio hover-effect-target mt-3 mt-sm-0" style="--fn-aspect-ratio: calc(216 / 416 * 100%)">
                <img src="{{ asset('assets/img/home/real-estate/categories/01.png') }}" alt="Image">
              </div>
            </div>
          </article>
        </div>

        <!-- Sell card -->
        <div class="swiper-slide">
          <article class="card hover-effect-scale bg-info border-0 overflow-hidden text-center">
            <div class="card-body pt-sm-5 pb-3">
              <svg class="text-white my-3 mt-sm-0" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"><path d="M27.216 18.697c-2.198 0-3.986 1.752-3.986 3.905s1.788 3.905 3.986 3.905 3.986-1.752 3.986-3.905-1.788-3.905-3.986-3.905zm0 5.972c-1.164 0-2.111-.928-2.111-2.068s.947-2.068 2.111-2.068 2.111.928 2.111 2.068-.947 2.068-2.111 2.068zm17.328 2.772l3.182-3.117c.366-.359.366-.94 0-1.299l-5.337-5.228V8.664c0-.507-.42-.918-.937-.918h-5.25c-.518 0-.937.411-.937.918v2.153L29.47 5.142a3.24 3.24 0 0 0-4.508 0L21.8 8.239c-1.194-4.72-5.555-8.23-10.738-8.23a11.22 11.22 0 0 0-3.958.714c-.483.182-.725.713-.54 1.186s.728.71 1.211.529a9.32 9.32 0 0 1 3.287-.593c5.066 0 9.188 4.038 9.188 9s-4.121 9-9.187 9-9.188-4.037-9.188-9a8.8 8.8 0 0 1 .605-3.219c.185-.474-.057-1.005-.54-1.186s-1.026.056-1.211.53C.245 8.206 0 9.51 0 10.846c0 5.077 3.583 9.349 8.401 10.519l-1.694 1.659c-.366.359-.366.94 0 1.299l3.182 3.117a.94.94 0 0 0 .452.245v13.833H8.654c-.518 0-.937.411-.937.918v3.674c0 .507.42.918.937.918h37.125c.518 0 .938-.411.938-.918v-3.674c0-.507-.42-.918-.937-.918h-1.687V27.685a.93.93 0 0 0 .452-.245zM37.139 9.583h3.375v6.378l-3.375-3.306V9.583zM26.288 6.44a1.32 1.32 0 0 1 .928-.377 1.32 1.32 0 0 1 .928.377l17.592 17.234-1.856 1.818L27.879 9.817a.95.95 0 0 0-1.326 0l-5.263 5.155a10.59 10.59 0 0 0 .834-4.127 10.75 10.75 0 0 0-.005-.322l4.169-4.084zM8.696 23.674l2.038-1.996.329.005a11.2 11.2 0 0 0 4.213-.817l-4.723 4.627-1.856-1.818zm36.145 21.518H9.591v-1.837h35.25v1.837zm-14.062-3.674h-7.125V30.682h7.125v10.837zm1.875 0V29.763c0-.507-.42-.918-.937-.918h-9c-.518 0-.937.411-.937.918v11.755h-9.562V26.46l15-14.694 15 14.694v15.059h-9.562zM11.019 13.897c-.801.006-1.03-.03-1.637-.419a.95.95 0 0 0-1.298.266c-.283.425-.162.994.271 1.271.677.434 1.179.614 1.783.682v.286c0 .507.42.918.938.918s.938-.411.938-.918v-.402a3.2 3.2 0 0 0 2.165-2.471c.242-1.413-.539-2.689-1.946-3.176-.753-.261-1.585-.575-2.046-.929-.119-.091-.17-.321-.124-.558.024-.123.134-.536.559-.661.793-.233 1.507.264 1.514.269a.95.95 0 0 0 1.309-.19c.306-.403.218-.976-.186-1.281-.266-.194-.708-.43-1.245-.57v-.306c0-.507-.42-.918-.937-.918s-.937.411-.937.918v.303l-.057.016c-.956.281-1.669 1.078-1.862 2.079-.178.925.132 1.823.81 2.344.672.517 1.637.89 2.578 1.216.753.261.775.826.721 1.14a1.31 1.31 0 0 1-1.311 1.092zM3.904 4.75c.518 0 .938-.411.938-.918s-.42-.918-.937-.918-.937.411-.937.918.42.918.938.918z"></path></svg>
              <h3 class="h5 text-white mb-0">Sell a property</h3>
            </div>
            <div class="card-footer d-flex flex-column align-items-center gap-4 gap-sm-5 bg-transparent border-0 p-0">
              <a class="btn btn-dark stretched-link mx-4" href="#!">Place an ad</a>
              <div class="ratio hover-effect-target mt-3 mt-sm-0" style="--fn-aspect-ratio: calc(216 / 416 * 100%)">
                <img src="{{ asset('assets/img/home/real-estate/categories/02.png') }}" alt="Image">
              </div>
            </div>
          </article>
        </div>

        <!-- Rent card -->
        <div class="swiper-slide">
          <article class="card hover-effect-scale bg-warning-subtle border-0 overflow-hidden text-center">
            <div class="card-body pt-sm-5 pb-3">
              <svg class="text-dark-emphasis my-3 mt-sm-0" xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"><path d="M5.208 44.81h37.691A5.09 5.09 0 0 0 48 39.682V26.689c0-2.842-2.258-5.181-5.101-5.181h-1.573L27.491 8.564a3.77 3.77 0 0 0 .375-1.64c-.001-2.105-1.709-3.811-3.815-3.81s-3.811 1.709-3.81 3.815c0 .566.128 1.125.375 1.634L6.781 21.508H5.208C2.366 21.508 0 23.847 0 26.689v12.993c0 2.842 2.366 5.128 5.208 5.128zM24.054 4.837c1.157 0 2.094.938 2.094 2.094s-.937 2.094-2.094 2.094-2.094-.937-2.094-2.094.938-2.093 2.094-2.094zm-2.359 5.072a3.77 3.77 0 0 0 4.719-.003l12.399 11.603H9.295L21.694 9.908zm24.588 29.747c0 1.898-1.539 3.436-3.436 3.436H5.154c-1.898 0-3.436-1.539-3.436-3.436V26.662c0-1.898 1.539-3.436 3.436-3.436h37.691c1.898 0 3.436 1.539 3.436 3.436v12.993zm-34.954-2.639c.419 0 .805-.172.805-.516v-2.537h.763l1.471 2.831a.56.56 0 0 0 .537.299c.494 0 1.052-.457 1.052-.876.001-.069-.018-.138-.054-.196l-1.31-2.375c.752-.29 1.3-.995 1.3-2.198 0-1.75-1.17-2.316-2.642-2.316h-2.223a.52.52 0 0 0-.505.54v6.829c0 .344.387.516.805.516zm.805-6.381h1.117c.601 0 .966.268.966 1.02s-.365 1.02-.966 1.02h-1.117v-2.04zm6.453 6.335h3.823c.354 0 .505-.343.505-.687 0-.397-.183-.709-.505-.709h-2.867v-1.826h1.6c.354 0 .505-.344.505-.633 0-.344-.183-.655-.505-.655h-1.6v-1.826h2.867c.322 0 .505-.365.505-.762 0-.344-.15-.741-.505-.741h-3.823c-.365 0-.763.206-.763.55v6.819c0 .344.397.47.763.47zm6.971.045c.419 0 .859-.172.859-.516v-3.65l2.029 3.716c.204.376.526.451.913.451.419 0 .816-.172.816-.516v-6.829c0-.354-.387-.505-.805-.505s-.805.151-.805.505v3.651l-1.756-3.318c-.408-.784-.652-.838-1.253-.838-.419 0-.857.161-.857.515v6.819c0 .343.441.516.859.516zm6.892-6.381h1.482v5.866c0 .344.44.516.859.516s.859-.172.859-.516v-5.866h1.439c.322 0 .505-.355.505-.762 0-.354-.151-.741-.505-.741H32.45c-.354 0-.505.387-.505.741 0 .408.183.762.505.762z"></path></svg>
              <h3 class="h5 mb-0">Rent a property</h3>
            </div>
            <div class="card-footer d-flex flex-column align-items-center gap-4 gap-sm-5 bg-transparent border-0 p-0">
              <a class="btn btn-dark stretched-link mx-4" href="#!">Find a rental</a>
              <div class="ratio hover-effect-target mt-3 mt-sm-0" style="--fn-aspect-ratio: calc(216 / 416 * 100%)">
                <img src="{{ asset('assets/img/home/real-estate/categories/03.png') }}" alt="Image">
              </div>
            </div>
          </article>
        </div>
      </div>

      <!-- Pagination (Bullets) -->
      <div class="swiper-pagination position-static mt-3 mt-sm-4"></div>
    </div>
  </section>


  <!-- Top offers -->
  <section class="container pt-2 pb-sm-2 pt-sm-3 py-md-4 py-lg-5 mt-xxl-3 mb-xxl-2">
    <div class="d-flex align-items-center justify-content-between gap-4 pb-3 mb-2 mb-sm-3 mb-lg-4">
      <h2 class="h1 mb-0">Top offers</h2>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-start bg-body rounded-circle me-1" id="offers-prev" aria-label="Prev">
          <i class="fi-chevron-left fs-lg animate-target"></i>
        </button>
        <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-end bg-body rounded-circle" id="offers-next" aria-label="Next">
          <i class="fi-chevron-right fs-lg animate-target"></i>
        </button>
      </div>
    </div>

    <div class="swiper pb-5" data-swiper='{"slidesPerView":1,"spaceBetween":24,"loop":true,"navigation":{"prevEl":"#offers-prev","nextEl":"#offers-next"},"pagination":{"el":".swiper-pagination","clickable":true},"breakpoints":{"460":{"slidesPerView":2},"768":{"slidesPerView":3},"992":{"slidesPerView":4}}}'>
      <div class="swiper-wrapper">
        @foreach([1,4,6,2] as $img)
        <div class="swiper-slide h-auto">
          <article class="card hover-effect-opacity h-100">
            <div class="card-img-top position-relative bg-body-tertiary overflow-hidden">
              <div class="swiper z-2" data-swiper='{"pagination":{"el":".swiper-pagination"},"navigation":{"prevEl":".btn-prev","nextEl":".btn-next"},"breakpoints":{"991":{"allowTouchMove":false}}}'>
                <a class="swiper-wrapper" href="#!">
                  <div class="swiper-slide">
                    <div class="ratio d-block" style="--fn-aspect-ratio: calc(248 / 362 * 100%)">
                      <img src="{{ asset("assets/img/listings/real-estate/0{$img}.jpg") }}" alt="Image">
                      <span class="position-absolute top-0 start-0 w-100 h-100 z-1" style="background: linear-gradient(180deg, rgba(0,0,0, 0) 0%, rgba(0,0,0, .11) 100%)"></span>
                    </div>
                  </div>
                </a>
                <div class="d-flex flex-column gap-2 align-items-start position-absolute top-0 start-0 z-1 pt-1 pt-sm-0 ps-1 ps-sm-0 mt-2 mt-sm-3 ms-2 ms-sm-3">
                  <span class="badge text-bg-info d-inline-flex align-items-center">
                    Verified
                    <i class="fi-shield ms-1"></i>
                  </span>
                  <span class="badge text-bg-primary">New</span>
                </div>
                <div class="position-absolute top-0 end-0 z-1 hover-effect-target opacity-0 pt-1 pt-sm-0 pe-1 pe-sm-0 mt-2 mt-sm-3 me-2 me-sm-3">
                  <button type="button" class="btn btn-sm btn-icon btn-light bg-light border-0 rounded-circle animate-pulse" aria-label="Add to wishlist">
                    <i class="fi-heart animate-target fs-sm"></i>
                  </button>
                </div>
                <div class="position-absolute top-50 start-0 z-1 translate-middle-y d-none d-lg-block hover-effect-target opacity-0 ms-3">
                  <button type="button" class="btn btn-sm btn-prev btn-icon btn-light bg-light rounded-circle animate-slide-start" aria-label="Prev">
                    <i class="fi-chevron-left fs-lg animate-target"></i>
                  </button>
                </div>
                <div class="position-absolute top-50 end-0 z-1 translate-middle-y d-none d-lg-block hover-effect-target opacity-0 me-3">
                  <button type="button" class="btn btn-sm btn-next btn-icon btn-light bg-light rounded-circle animate-slide-end" aria-label="Next">
                    <i class="fi-chevron-right fs-lg animate-target"></i>
                  </button>
                </div>
                <div class="swiper-pagination bottom-0 mb-2" data-bs-theme="light"></div>
              </div>
            </div>
            <div class="card-body p-3">
              <div class="pb-1 mb-2">
                <span class="badge text-body-emphasis bg-body-secondary">For rent</span>
              </div>
              <div class="h5 mb-2">$1,620</div>
              <h3 class="fs-sm fw-normal text-body mb-2">
                <a class="stretched-link text-body" href="#!">40 S 9th St, Brooklyn, NY 11249</a>
              </h3>
              <div class="h6 fs-sm mb-0">65 sq.m</div>
            </div>
            <div class="card-footer d-flex gap-2 border-0 bg-transparent pt-0 pb-3 px-3 mt-n1">
              <div class="d-flex align-items-center fs-sm gap-1 me-1">
                2<i class="fi-bed-single fs-base text-secondary-emphasis"></i>
              </div>
              <div class="d-flex align-items-center fs-sm gap-1 me-1">
                1<i class="fi-shower fs-base text-secondary-emphasis"></i>
              </div>
              <div class="d-flex align-items-center fs-sm gap-1 me-1">
                1<i class="fi-car-garage fs-base text-secondary-emphasis"></i>
              </div>
            </div>
          </article>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination position-static pt-lg-1 mt-3 mt-sm-4"></div>
    </div>
  </section>


  <!-- Properties by city -->
  <section class="container pt-2 pb-sm-2 pt-sm-3 py-md-4 py-lg-5 mt-xxl-3 mb-xxl-2">
    <div class="d-flex align-items-center justify-content-between gap-4 pb-3 mb-2 mb-sm-3 mb-lg-4">
      <h2 class="h1 mb-0">Search by city</h2>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-start bg-body rounded-circle me-1" id="city-prev" aria-label="Prev">
          <i class="fi-chevron-left fs-lg animate-target"></i>
        </button>
        <button type="button" class="btn btn-icon btn-outline-secondary animate-slide-end bg-body rounded-circle" id="city-next" aria-label="Next">
          <i class="fi-chevron-right fs-lg animate-target"></i>
        </button>
      </div>
    </div>

    <div class="swiper pb-5" data-swiper='{"slidesPerView":1,"spaceBetween":24,"loop":true,"navigation":{"prevEl":"#city-prev","nextEl":"#city-next"},"pagination":{"el":".swiper-pagination","clickable":true},"breakpoints":{"460":{"slidesPerView":2,"spaceBetween":16},"768":{"slidesPerView":2,"spaceBetween":24},"860":{"slidesPerView":3},"1200":{"slidesPerView":4}}}'>
      <div class="swiper-wrapper">
        @foreach(['01','02','03','04','05','06'] as $city)
        <div class="swiper-slide h-auto">
          <article class="card h-100 hover-effect-scale bg-transparent">
            <div class="card-img-top bg-body-tertiary overflow-hidden">
              <div class="ratio hover-effect-target" style="--fn-aspect-ratio: calc(230 / 306 * 100%)">
                <img src="{{ asset("assets/img/home/real-estate/cities/{$city}.jpg") }}" alt="Image">
              </div>
            </div>
            <div class="card-body text-center p-3">
              <h3 class="h5 mb-0">
                <a class="hover-effect-underline stretched-link" href="#!">City {{ $city }}</a>
              </h3>
            </div>
            <div class="card-footer d-flex bg-transparent border-0 pt-0 pb-3 px-3 mt-n1">
              <div class="w-50 text-center pe-1">
                <i class="fi-zap mb-1"></i>
                <div class="fs-sm">for sale <span class="fw-semibold">1739</span></div>
              </div>
              <hr class="vr my-0 mx-2">
              <div class="w-50 text-center ps-1">
                <i class="fi-tag mb-1"></i>
                <div class="fs-sm">for rent <span class="fw-semibold">3845</span></div>
              </div>
            </div>
          </article>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination position-static pt-lg-1 mt-3 mt-sm-4"></div>
    </div>
  </section>


  {{-- <!-- Partners -->
  <section class="bg-body-tertiary py-5">
    <div class="container pt-2 pb-sm-2 pt-sm-3 py-md-4 py-lg-5 my-xxl-3">
      <h2 class="h1 text-center pb-sm-2 pb-md-3 mb-lg-4">Our partners</h2>
      <div class="swiper" data-swiper='{"slidesPerView":1,"spaceBetween":0,"pagination":{"el":".swiper-pagination","clickable":true},"breakpoints":{"400":{"slidesPerView":2},"600":{"slidesPerView":3,"spaceBetween":0},"900":{"slidesPerView":4,"spaceBetween":16},"1200":{"slidesPerView":5,"spaceBetween":16},"1400":{"slidesPerView":5,"spaceBetween":24}}}'>
        <div class="swiper-wrapper">
          @for($i=0;$i<5;$i++)
          <div class="swiper-slide">
            <div class="nav justify-content-center">
              <a class="nav-link text-body-secondary p-0" href="#!" aria-label="Partner">
                <svg xmlns="http://www.w3.org/2000/svg" width="240" viewBox="0 0 240 81" fill="currentColor"><rect width="240" height="20" rx="8"></rect></svg>
              </a>
            </div>
          </div>
          @endfor
        </div>
        <div class="swiper-pagination position-static mt-sm-2"></div>
      </div>
    </div>
  </section> --}}


  <!-- Top agents -->
  <section class="container pt-2 pt-sm-3 pt-md-4 pt-lg-5 pb-5 my-xxl-3">
    <h2 class="h1 text-center pt-5 pb-3 mb-2 mb-sm-3 mb-lg-4">Top real estate agents</h2>
    <div class="row row-cols-2 row-cols-md-4 g-4 mb-n3">
      @foreach([1,2,3,4] as $agent)
      <div class="col mb-3">
        <article class="hover-effect-scale text-center">
          <div class="position-relative mb-3">
            <div class="ratio ratio-1x1 bg-body-secondary rounded-circle overflow-hidden mx-auto" style="width: 132px">
              <img src="{{ asset("assets/img/home/real-estate/agents/0{$agent}.png") }}" class="hover-effect-target" alt="Avatar">
            </div>
            <h3 class="h5 pt-3 mt-sm-1 mb-1">
              <a class="hover-effect-underline stretched-link" href="#!">Agent {{ $agent }}</a>
            </h3>
            <p class="fs-sm mb-0">Premium Property Group</p>
          </div>
          <div class="d-flex justify-content-center gap-1">
            <a class="btn btn-icon btn-sm btn-outline-secondary border-0" href="#!" aria-label="Instagram"><i class="fi-instagram fs-base"></i></a>
            <a class="btn btn-icon btn-sm btn-outline-secondary border-0" href="#!" aria-label="Facebook"><i class="fi-facebook fs-base"></i></a>
            <a class="btn btn-icon btn-sm btn-outline-secondary border-0" href="#!" aria-label="LinkedIn"><i class="fi-linkedin fs-base"></i></a>
          </div>
        </article>
      </div>
      @endforeach
    </div>
  </section>

</main>
@endsection
