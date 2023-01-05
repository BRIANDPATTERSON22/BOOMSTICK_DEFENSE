<aside class="control-sidebar control-sidebar-dark">
    <!--
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    -->

    <div class="tab-content">
        <div class="tab-pane active" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Site Options</h3>
            <ul class='control-sidebar-menu'>
                <li>
                    <a href="{{url('/')}}" target="_blank">
                        <i class="menu-icon fa fa-globe bg-green"></i>
                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Public view</h4>
                            <p>{{str_limit(url('/'), 25)}}</p>
                        </div>
                    </a>
                </li>

                @hasanyrole('super-admin|admin')
                    <li>
                        <a href="{{url('admin/options')}}">
                            <i class="menu-icon fa fa-gear bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Settings</h4>
                                <p>Last update: {{$option->updated_at->format('d M, Y')}}</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/cache/flush')}}">
                            <i class="menu-icon fa fa-refresh bg-orange"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Clear Cache</h4>
                                <p>Flush all cache data</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('admin/pages')}}">
                            <i class="menu-icon fa fa-file bg-purple"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Pages</h4>
                                <p>Manage Pages</p>
                            </div>
                        </a>
                    </li>
                @endhasanyrole
            </ul>

            @hasanyrole('super-admin|admin')
                <ul class='control-sidebar-menu'>
                    @if($option->status == 1)
                        <li>
                            <a href="{{url('admin/maintenance/down')}}">
                                <i class="menu-icon fa fa-thumbs-o-down bg-blue"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Put Offline</h4>
                                    <p>The site is online now</p>
                                </div>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{url('admin/maintenance/up')}}">
                                <i class="menu-icon fa fa-thumbs-o-up bg-blue-active"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Put Online</h4>
                                    <p>The site is offline now</p>
                                </div>
                            </a>
                        </li>
                    @endif
                </ul>
            @endhasanyrole

            @hasanyrole('super-admin|admin')
                <h3 class="control-sidebar-heading">User Management</h3>
                <ul class='control-sidebar-menu'>
                    <li>
                        <a href="{{url('admin/users')}}">
                            <i class="menu-icon fa fa-user-secret bg-red"></i>
                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Users</h4>
                                <p>Manage users</p>
                            </div>
                        </a>
                    </li>
                </ul>
            @endhasanyrole
        </div>

        <div class="tab-pane" id="control-sidebar-stats-tab">

        </div>
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading"></h3>
                <div class="form-group">
                    <label class="control-sidebar-subheading">

                    </label>
                    <p>

                    </p>
                </div>
            </form>
        </div>
    </div>

</aside>
<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class='control-sidebar-bg'></div>