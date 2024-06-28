  <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="https://bilikhukum.com/" class="app-brand-link">
              <span class="app-brand-logo demo">
                <img src="{{ asset('assets/img/member/default.webp') }}" alt="Bilik Hukum Logo" width="35">
              </span>
              <span class="app-brand-text demo menu-text fw-bold ms-2">Bilik Hukum</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>
          @if (!function_exists('isActiveSubMenu'))
              @php
                  function isActiveSubMenu($title)
                  {
                      $currentUrl = request()->path();
                      $urlParts = explode('/', $currentUrl);

                      // Check if the title matches the first segment of the URL
                      return $title == $urlParts[0] ? 'active' : '';
                  }
              @endphp
          @endif

          @if (!function_exists('isActiveChildSubMenu'))
              @php
                  function isActiveChildSubMenu($childRoute)
                  {
                      $currentUrl = str_replace('/', '.', request()->path());
                      return $childRoute == $currentUrl ? 'active' : '';
                  }
              @endphp
          @endif

          <ul class="menu-inner py-1">
            @php                
              $sortedSidebar = $sidebar->sortBy('menu.order');
            @endphp
            @foreach($sortedSidebar as $accessMenu)
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $accessMenu->menu->menu_name }}</span>
                </li>
                @php                    
                    $sortedAccessSubs = $accessMenu->accessSubs->sortBy('menuSub.order');
                @endphp
                @foreach($sortedAccessSubs as $accessSub)
                    @if($accessSub->menuSub->menu_id == $accessMenu->menu_id)
                        <li class="menu-item {{ isActiveSubMenu($accessSub->menuSub->title) }}">
                            <a href="{{ $accessSub->menuSub->itemsub != 1 ? route($accessSub->menuSub->url) : 'javascript:void(0);' }}" class="menu-link {{ $accessSub->menuSub->itemsub != 0 ? 'menu-toggle' : '' }}">
                                <i class="menu-icon tf-icons {{ $accessSub->menuSub->icon }}"></i>                
                                <div class="text-truncate" data-i18n="{{ ucfirst($accessSub->menuSub->title) }}">{{ ucfirst($accessSub->menuSub->title) }}</div>
                            </a>
                            @if($accessSub->menuSub->itemsub != 0)
                                @php                                    
                                    $sortedAccessSubChildren = $accessSub->accessSubChildren->sortBy('menuSubChild.order');                        
                                @endphp
                                <ul class="menu-sub">
                                    @foreach($sortedAccessSubChildren as $accessSubChild)
                                        @if($accessSubChild->menuSubChild->id_submenu == $accessSub->menuSub->id) <!-- Check to ensure child belongs to the correct submenu -->
                                            <li class="menu-item {{ isActiveChildSubMenu($accessSubChild->menuSubChild->url) }}">
                                                <a href="{{ route($accessSubChild->menuSubChild->url) }}" class="menu-link">
                                                    <div class="text-truncate" data-i18n="{{ ucfirst($accessSubChild->menuSubChild->title) }}">{{ ucfirst($accessSubChild->menuSubChild->title) }}</div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            @endforeach

        </ul>
            
        
        
        
          {{-- <ul class="menu-inner py-1">
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Dashboard</span>
            </li>
            <li class="menu-item active">
              <a href="dashboards-analytics.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Office</span>
            </li>
            <!-- Layouts -->
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building-house"></i>                
                <div class="text-truncate" data-i18n="Pengacara">Pengacara</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Pengacara">List Pengacara</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Konsultasi">List Konsultasi</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Office Details">Office Details</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Review">Review</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Pengaturan">Pengaturan</div>
                  </a>
                </li>
              </ul>             
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building"></i>                
                <div class="text-truncate" data-i18n="Notaris">Notaris</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Notaris">List Notaris</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Konsultasi">List Konsultasi</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Office Details">Office Details</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Review">Review</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Pengaturan">Pengaturan</div>
                  </a>
                </li>
              </ul>             
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>                
                <div class="text-truncate" data-i18n="Mediator">Mediator</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Pengacara">List Pengacara</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="List Konsultasi">List Konsultasi</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Office Details">Office Details</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Review">Review</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-collapsed-menu.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Pengaturan">Pengaturan</div>
                  </a>
                </li>
              </ul>             
            </li>

            <!-- Apps & Pages -->
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Account</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div class="text-truncate" data-i18n="Profile">Profile</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Account">Account</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Security">Security</div>
                  </a>
                </li>
              </ul>
            </li>    
            <li class="menu-item">
              <a href="app-calendar.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-voice"></i>
                <div class="text-truncate" data-i18n="Refferal">Refferal</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Admin</span>
            </li>       
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div class="text-truncate" data-i18n="Menu">Menu</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Menu">Menu</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Sub Menu">Sub Menu</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="ChildSub Menu">ChildSub Menu</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-git-repo-forked"></i>
                <div class="text-truncate" data-i18n="Role">Role</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="http://127.0.0.1:8000/role" class="menu-link">
                    <div class="text-truncate" data-i18n="List Role">List Role</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="app-user-list.html" class="menu-link">
                    <div class="text-truncate" data-i18n="Access Role">Access Role</div>
                  </a>
                </li>               
              </ul>
            </li>
          </ul> --}}
        </aside>
        <!-- / Menu -->