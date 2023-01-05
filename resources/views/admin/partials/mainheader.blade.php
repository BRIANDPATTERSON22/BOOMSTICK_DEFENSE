<header class="main-header">
    <a href="{{ url('admin/dashboard') }}" class="logo" title="{{$option->name}}">
        <span class="logo-mini">{{strtoupper(substr($option->name, 0, 2))}}</span>
        <span class="logo-lg"><b>{{strtoupper(str_limit($option->name, 15))}}</b></span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @can('view feedbacks')
                    <li class="dropdown messages-menu">
                        <?php
                        $totalCount = count($contacts);
                        $unRead = [];
                        foreach($contacts as $row){
                            if($row->is_viewed != 1) $c = 1; else $c = 0;
                            $unRead[] = $c;
                        }
                        $urCount = array_sum($unRead);
                        ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">{{$urCount}}</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="header">You have {{$urCount}} unread messages from {{$totalCount}}</li>
                            <li>
                                <ul class="menu">
                                    @foreach($contacts as $row)
                                        @if($row->is_viewed != 1)
                                            <li>
                                                <a href="{{url('admin/contact/'.$row->id.'/view')}}">
                                                    <h4>
                                                        {{$row->first_name}}
                                                        <small><i class="fa fa-clock-o"></i>
                                                            <?php
                                                            $currentTime = date('Y-m-d h:i:s');
                                                            $sentDate = $row->created_at;
                                                            $datetime1 = new DateTime($currentTime);
                                                            $datetime2 = new DateTime($sentDate);
                                                            $interval = $datetime1->diff($datetime2);
                                                            echo $interval->format('%a days');
                                                            ?>
                                                        </small>
                                                    </h4>
                                                    <p>{{str_limit($row->inquiry, 30)}}</p>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li class="footer"><a href="{{url('/admin/contacts')}}">See All Messages</a></li>
                        </ul>
                    </li>
                @endcan

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(Auth::user()->image)
                            <img src="{{asset('storage/users/'.Auth::id().'/'.Auth::user()->image)}}" class="user-image" alt="Image">
                        @else
                            <img src="{{asset('site/defaults/avatar.jpg')}}" class="user-image" alt="Image">
                        @endif
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            @if(Auth::user()->image)
                                <img src="{{asset('storage/users/'.Auth::id().'/'.Auth::user()->image)}}" class="img-circle" alt="User">
                            @else
                                <img src="{{asset('site/defaults/avatar.jpg')}}" class="img-circle" alt="User">
                            @endif
                            <p>
                                {{ Auth::user()->name }}
                                <small>Since {{ Auth::user()->created_at->format('d M, Y') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{url('admin/user/profile')}}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>