<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('profiles')}}" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{\Config::get('app.name')}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            @foreach ($navItems as $key => $val)
                @if($key != "Static Pages")
                <li class="nav-item">
                    <a href="{{route($val['route'])}}" class="nav-link {{$val['route'] == Route::currentRouteName() ? "active" : ""}}">
                        <i class="nav-icon fas {{$val['iconClass']}}"></i>
                        <p>{{$key}}</p>
                    </a>
                </li>
                @else
                <li class="nav-item @if(str_contains(Request::url(),'static-pages')) menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link {{ request()->is('static-pages*') ? 'active' : '' }}">
                       <i class="nav-icon fas fa-list"></i>
                       <p>
                          {{$key}}
                          <i class="fas fa-angle-left right"></i>
                       </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($val as $subKey => $subValue )
                        <li class="nav-item">
                            @php
                                $page = Route::current()->parameters['slug']?? "";
                            @endphp
                           <a  href="{{route($subValue['route'],$subValue['param'])}}" class="nav-link  {{$subValue['param']['slug'] == $page ? "active" : ""}}">
                              <i class="far fa-circle  {{$subValue['iconClass']}}"></i>
                              <p>{{$subKey}}</p>
                           </a>
                        </li>
                        @endforeach
                    </ul>
                 </li>
                @endif
            @endforeach
        </ul>
      </nav>
    </div>
  </aside>
