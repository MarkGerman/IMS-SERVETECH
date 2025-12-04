<div>
    <aside class="main-sidebar sidebar-dark-primary bg-purple elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
          {{-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
          <span class="brand-text text- font-weight-light">Dashboard</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{Auth::user()->profile_picture ?  asset('assets/uploads/'.Auth::user()->profile_picture) : asset('face-0.jpg') }}" width="60" height="60" class="rounded-circle" alt="User Image">
            </div>
            <div class="info">
              <a href="{{ route('user.profile') }}" class="d-block text-capitalize ">{{ Auth::user()->name }}  </a>
              <span class="badge bg-success text-capitalize  " >{{ Auth::user()->role }}</span>
            </div>
          </div>
          
          <!-- SidebarSearch Form -->
          <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
              <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
                </button>
              </div>
            </div>
          </div>
    
          @if(Auth::user()->role == "admin")
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ route('root') }}" class="nav-link">
                  <i class="nav-icon fa fa-globe "></i>
                  
                  <p>
                    Home Page
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('users') }}" class="nav-link">
                  
                  <i class=" nav-icon fa fa-users" aria-hidden="true"></i>
                  <p>
                    Users
                   
                  </p>
                </a>
              </li>
              {{-- <li class="nav-header">Hero</li>
              <li class="nav-item">
                
              </li> --}}
              <li class="nav-header">Blog</li>
              <li class="nav-item">
                <a href="{{ route('posts') }}" class="nav-link">
                  
                  <i class=" nav-icon fa fa-coffee" aria-hidden="true"></i>
                  <p>
                    Posts
                   
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('categories') }}" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Categories
                    
                  </p>
                </a>
               
              </li>
              <li class="nav-item">
                <a href="{{ route('tags') }}" class="nav-link">
                  
                  
                  <i class=" nav-icon fa fa-hashtag" aria-hidden="true"></i>
                  <p>
                    Tags
                    
                  </p>
                </a>
               
              </li>

              <li class="nav-header">Home Page</li>
              <li class="nav-item">
                <a href="{{ route('hero') }}" class="nav-link">
                  <i class="fa fa-arrow-up nav-icon " aria-hidden="true"></i>
                  <p>Hero</p>
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">
                  <i class="fa fa-list nav-icon " aria-hidden="true"></i>
                  <p>About</p>
                  
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('testimonials') }}" class="nav-link">
                  <i class="fa fa-microphone nav-icon " aria-hidden="true"></i>
                  <p>Testimonials</p>

                  
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('whys') }}" class="nav-link">
                  <i class="fa fa-question nav-icon " aria-hidden="true"></i>
                  <p>WHYs</p>
                  
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('partners') }}" class="nav-link">
                  <i class="fa fa-users nav-icon " aria-hidden="true"></i>
                  <p>Partners</p>
                  
                </a>
              </li>

             
              <li class="nav-item">
                <a href="{{ route('footer') }}" class="nav-link">
                  <i class="fa fa-arrow-down nav-icon " aria-hidden="true"></i>
                  <p>Footer</p>
                  
                </a>
              </li>
              <li class="nav-header">Intake & Candidates</li>
              <li class="nav-item">
                <a href="{{ route('intake') }}" class="nav-link">
                  <i class="fa fa-leaf nav-icon " aria-hidden="true"></i>
                  <p>Intake</p>
                </a>
              </li>
              <li class="nav-header">Educational Programs</li>
              <li class="nav-item">
                <a href="{{ route('programs') }}" class="nav-link">
                  <i class="fa fa-leaf nav-icon " aria-hidden="true"></i>
                  <p>Programs / Courses</p>
                </a>
              </li>
              
            
              <li class="nav-item ">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"  class="nav-link">
                  
                  <i class="nav-icon fas fa-door-open"></i>
                  <p class="text-danger" >
                    Logout
                    <form id="logout" action="{{route('logout') }}"  method="POST" >
                        @csrf
                    </form>
                  </p>
                </a>   
              </li>
              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
          @endif

          @if(Auth::user()->role == "staff")
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ route('root') }}" class="nav-link">
                  <i class="nav-icon fa fa-globe "></i>
                  
                  <p>
                    Home Page
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    
                  </p>
                </a>
                
              </li>
              {{-- <li class="nav-item">
                <a href="{{ route('users') }}" class="nav-link">
                  
                  <i class=" nav-icon fa fa-users" aria-hidden="true"></i>
                  <p>
                    Users
                   
                  </p>
                </a>
              </li>
              <li class="nav-header">Hero</li>
              <li class="nav-item">
                <a href="{{ route('hero') }}" class="nav-link">
                  
                  <i class="fas fa-image "></i>
                  <p>
                    Hero Image 
                  </p>
                </a>
              </li> --}}
              <li class="nav-header">Blog</li>
              <li class="nav-item">
                <a href="{{ route('posts') }}" class="nav-link">
                  
                  <i class=" nav-icon fa fa-coffee" aria-hidden="true"></i>
                  <p>
                    Posts
                   
                  </p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{ route('categories') }}" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Categories
                    
                  </p>
                </a>
               
              </li> --}}
              {{-- <li class="nav-item">
                <a href="{{ route('tags') }}" class="nav-link">
                  
                  
                  <i class=" nav-icon fa fa-hashtag" aria-hidden="true"></i>
                  <p>
                    Tags
                    
                  </p>
                </a>
               
              </li> --}}

              {{-- <li class="nav-item">
                <a href="{{ route('subscribers') }}" class="nav-link">
                  
                  <i class=" nav-icon fa fa-at" aria-hidden="true"></i>
                  <p>
                    Subscribers
                    
                  </p>
                </a>
               
              </li> --}}
              {{-- <li class="nav-header">Home Page</li>
              <li class="nav-item">
                <a href="{{ route('section.partners') }}" class="nav-link">
                  <i class="fa fa-leaf nav-icon " aria-hidden="true"></i>
                  <p>Partners</p>
                </a>
              </li> --}}
              <li class="nav-header">Training</li>
              {{-- <li class="nav-item">
                <a href="{{ route('cohort') }}" class="nav-link">
                 
                 <i class="fa fa-calendar nav-icon "></i>
                  <p>Cohort</p>
                </a>
              </li> --}}

              <li class="nav-item">
                <a href="{{ route('cohort.candidates') }}" class="nav-link">
                  <i class="fa fa-users nav-icon" aria-hidden="true"></i>
                  <p>Cadidates</p>
                </a>
              </li>


              

              <li class="nav-item ">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"  class="nav-link">
                  
                  <i class="nav-icon fas fa-door-open"></i>
                  <p class="text-danger" >
                    Logout
                    <form id="logout" action="{{route('logout') }}"  method="POST" >
                        @csrf
                    </form>
                  </p>
                </a>
                
                
              </li>
              
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
          @endif
          @if(Auth::user()->role == "normal")

          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ route('root') }}" class="nav-link">
                  <i class="nav-icon fa fa-globe "></i>
                  
                  <p>
                    Home Page
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    
                  </p>
                </a>
                
              </li>

              <li class="nav-item ">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"  class="nav-link">
                  
                  <i class="nav-icon fas fa-door-open"></i>
                  <p class="text-danger" >
                    Logout
                    <form id="logout" action="{{route('logout') }}"  method="POST" >
                        @csrf
                    </form>
                  </p>
                </a>
                
                
              </li>
              
            </ul>
          </nav>

          @endif

        </div>
        <!-- /.sidebar -->
      </aside>



</div>
