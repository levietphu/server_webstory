<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="" alt="" width="50" height="50">
                </div>
                <div class="sidebar-brand-text mx-3">Quản trị truyện</div>
            </a>

            <!-- Divider -->
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('theloai.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Thể loại truyện</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('tacgia.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Tác giả</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('dichgia.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Dịch giả</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('truyen.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Truyện</span>
                </a>
            </li>
            <hr class="sidebar-divider my-0">
            <!-- Divider -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Cấu hình</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{route('logo.index')}}">Logo</a>
                        <a class="collapse-item" href="{{route('ads.index')}}">Ads</a>
                        <a class="collapse-item" href="{{route('contact.index')}}">Contact</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('banner.index')}}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Banner</span>
                </a>
            </li>
        </ul>