<!-- BEGIN: Header-->
<div class="header-navbar-shadow"></div>
<nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top">
    <div class="navbar-wrapper">
        <div class="navbar-container content  bg-white">
            <div class="navbar-collapse" id="navbar-mobile">

                <!--Start Left Links-->
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <!--Start Navbar Mobil Menu Bar-->
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);">
                                <i class="ficon bx bx-menu"></i>
                            </a>
                        </li>
                    </ul>
                    <!--End Navbar Mobil Menu Bar-->

                    <!--Start Bookmarked Links-->
                    <ul class="nav navbar-nav bookmark-icons">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{asset('app/email')}}" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{asset('app/chat')}}" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{asset('app/todo')}}" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon bx bx-check-circle"></i></a></li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{asset('app/calendar')}}" data-toggle="tooltip" data-placement="top" title="Calendar"><i class="ficon bx bx-calendar-alt"></i></a></li>
                      </ul>
                      <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                          <div class="bookmark-input search-input">
                            <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>
                            <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">
                            <ul class="search-list"></ul>
                          </div>
                        </li>
                      </ul>
                    <!--End Bookmarked Links-->
                </div>
                <!--End Left Links-->

                <!--Start Right Links-->
                <ul class="nav navbar-nav float-right" style="align-items: center;">
                    <!--Start Languges Menu-->
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-language"></i>
                            <span class="selected-language">{{LaravelLocalization::getCurrentLocaleNative()}}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="dropdown-item"
                                    rel="alternate"
                                    hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                                    data-language="{{$localeCode}}">
                                    <i class="fas fa-language mr-50"></i>
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                    <!--End Languges Menu-->

                    <!--Start Fullscreen-->
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link nav-link-expand">
                            <i class="ficon bx bx-fullscreen"></i>
                        </a>
                    </li>
                    <!--End Fullscreen-->

                    <!--Start Search-->
                    <li class="nav-item nav-search">
                        <a class="nav-link nav-link-search">
                            <i class="ficon bx bx-search"></i>
                        </a>
                        <div class="search-input">
                            <div class="search-input-icon">
                                <i class="bx bx-search primary"></i>
                            </div>
                            <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
                            <div class="search-input-close">
                                <i class="bx bx-x"></i>
                            </div>
                            <ul class="search-list"></ul>
                        </div>
                    </li>
                    <!--End Search-->

                    <!--Start Notifications Menu-->
                    <li class="dropdown dropdown-notification nav-item">
                        <a class="nav-link nav-link-label" href="javascript:void(0);" data-toggle="dropdown">
                            <i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i>
                            <span class="badge badge-pill badge-danger badge-up">5</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header px-1 py-75 d-flex justify-content-between">
                                    <span class="notification-title">7 new Notification</span>
                                    <span class="text-bold-400 cursor-pointer">Mark all as read</span>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                <a class="d-flex justify-content-between" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0">
                                                <img src="{{asset('app-assets')}}/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="39" width="39">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">Congratulate Socrates Itumay</span> for work anniversaries
                                            </h6>
                                            <small class="notification-text">Mar 15 12:32pm</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between read-notification cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0">
                                                <img src="{{asset('app-assets')}}/images/portrait/small/avatar-s-16.jpg" alt="avatar" height="39" width="39">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">New Message</span> received
                                            </h6>
                                            <small class="notification-text">You have 18 unread messages</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center py-0">
                                        <div class="media-left pr-0">
                                            <img class="mr-1" src="{{asset('app-assets')}}/images/icon/sketch-mac-icon.png" alt="avatar" height="39" width="39">
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">Updates Available</span>
                                            </h6>
                                            <small class="notification-text">Sketch 50.2 is currently newly added</small>
                                        </div>
                                        <div class="media-right pl-0">
                                            <div class="row border-left text-center">
                                                <div class="col-12 px-50 py-75 border-bottom">
                                                    <h6 class="media-heading text-bold-500 mb-0">Update</h6>
                                                </div>
                                                <div class="col-12 px-50 py-75">
                                                    <h6 class="media-heading mb-0">Close</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25">
                                                <span class="avatar-content text-primary font-medium-2">LD</span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">New customer</span> is registered
                                            </h6>
                                            <small class="notification-text">1 hrs ago</small>
                                        </div>
                                    </div>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="media d-flex align-items-center justify-content-between">
                                        <div class="media-left pr-0">
                                            <div class="media-body">
                                                <h6 class="media-heading">New Offers</h6>
                                            </div>
                                        </div>
                                        <div class="media-right">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" checked id="notificationSwtich">
                                                <label class="custom-control-label" for="notificationSwtich"></label>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-danger bg-lighten-5 mr-1 m-0 p-25">
                                                <span class="avatar-content">
                                                    <i class="bx bxs-heart text-danger"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">Application</span> has been approved
                                            </h6><small class="notification-text">6 hrs ago</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between read-notification cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0">
                                                <img src="{{asset('app-assets')}}/images/portrait/small/avatar-s-4.jpg" alt="avatar" height="39" width="39">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">New file</span> has been uploaded
                                            </h6>
                                            <small class="notification-text">4 hrs ago</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                <div class="avatar-content">
                                                    <i class="bx bx-detail text-danger"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">Finance report</span> has been generated
                                            </h6>
                                            <small class="notification-text">25 hrs ago</small>
                                        </div>
                                    </div>
                                </a>
                                <a class="d-flex justify-content-between cursor-pointer" href="javascript:void(0);">
                                    <div class="media d-flex align-items-center border-0">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0">
                                                <img src="{{asset('app-assets')}}/images/portrait/small/avatar-s-16.jpg" alt="avatar" height="39" width="39">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading">
                                                <span class="text-bold-500">New customer</span> comment recieved
                                            </h6>
                                            <small class="notification-text">2 days ago</small>
                                        </div>
                                    </div>
                                </a></li>
                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!--End Notifications Menu-->

                    <!--Start User Menu-->
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0);" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                <span class="user-status text-muted">{{app()->getLocale() == 'ar' ? auth()->user()->branch->name_ar : auth()->user()->branch->name_en}}</span>
                            </div>
                            <span>
                                <img class="round" src="{{auth()->user()->image_path}}" alt="avatar" height="40" width="40">
                            </span>
                            {{-- <span class="user_sub_name_img"> --}}
                                {{-- <img class="round" src="https://ui-avatars.com/api/?name={{ Auth::user()->first_name }} {{ Auth::user()->last_name }}&background=5A8DEE&color=fff" alt="avatar" height="40" width="40"> --}}
                                {{-- {{subUserName(Auth::user()->first_name, Auth::user()->last_name)}} --}}
                            {{-- </span> --}}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <a class="dropdown-item" href="{{route('editUserAccount')}}">
                                <i class="bx bx-user mr-50"></i>
                                {{trans('applang.my_account')}}
                            </a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bx bx-power-off mr-50"></i>
                                {{ trans('applang.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <!--End User Menu-->

                </ul>
                <!--End Right Links-->

            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->
