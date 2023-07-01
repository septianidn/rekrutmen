<nav id="navbar_main" class="mobile-offcanvas nav navbar navbar-expand-xl hover-nav horizontal-nav mx-md-auto">
   <div class="container-fluid">
      <div class="offcanvas-header">
         <div class="navbar-brand">
            <img src="{{ asset('images/backoffice/logo/logounand30.svg') }}" />
            <h4 class="logo-title">{{env('APP_NAME')}}</h4>
         </div>
         <button class="btn-close float-end"></button>
      </div>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link {{activeRoute(route('menu-style.horizontal'))}}" href="{{route('menu-style.horizontal')}}"> Horizontal </a></li>
         <li class="nav-item"><a class="nav-link {{activeRoute(route('menu-style.dualhorizontal'))}}" href="{{route('menu-style.dualhorizontal')}}"> Dual Horizontal </a></li>
         <li class="nav-item"><a class="nav-link {{activeRoute(route('menu-style.dualcompact'))}}" href="{{route('menu-style.dualcompact')}}"><span class="item-name">Dual Compact</span></a></li>
         <li class="nav-item"><a class="nav-link {{activeRoute(route('menu-style.boxed'))}}" href="{{route('menu-style.boxed')}}"> Boxed Horizontal </a></li>
         <li class="nav-item"><a class="nav-link {{activeRoute(route('menu-style.boxedfancy'))}}" href="{{route('menu-style.boxedfancy')}}"> Boxed Fancy</a></li>
      </ul>
   </div> <!-- container-fluid.// -->
</nav>
