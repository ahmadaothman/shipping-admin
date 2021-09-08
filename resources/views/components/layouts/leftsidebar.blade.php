<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ url('/') }}">
            <h3>KGSL</h3>
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
              
                <!--Home-->
                <li>
                    <a href="{{ url('/') }}" class="dropdown-toggle no-arrow">
                        <span class="fa fa-home"></span><span class="mtext">Home</span>
                    </a>
                </li>
               
                <!--Shipments-->
                <li>
                    <a href="/shipments" class="dropdown-toggle no-arrow">
                        <span class="fa fa-table"></span><span class="mtext">Shipments</span>
                    </a>
                </li>
                <!--Agents-->
                <li>
                <a href="/agents" class="dropdown-toggle no-arrow">
                    <i class="icon-copy fa fa-group" aria-hidden="true"></i><span class="mtext">Agents</span>
                </a>
                </li>
                   <!--Branch-->
                   <li>
                    <a href="/branches" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-map-marker" aria-hidden="true"></i><span class="mtext">Branches</span>
                    </a>
                    </li>
                <!--users-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i> Users</span>
                    </a>
                    <ul class="submenu">
                    
                        @foreach ($user_types as $item)
                            <li><a href="/users?user_type_id={{ $item->id }}">{!! $item->user_icon !!} {{ $item->name }}</li>
                        @endforeach
                    </ul>
                </li>
                <!--Invoices-->
                <li>
                    <a href="/invoices" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-dollar" aria-hidden="true"></i></i><span class="mtext">Invoices</span>
                    </a>
                </li>
                <!--reports-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="fa fa-pie-chart"></span><span class="mtext">Reports</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="highchart.php">Highchart</a></li>
                        <li><a href="knob-chart.php">jQuery Knob</a></li>
                        <li><a href="jvectormap.php">jvectormap</a></li>
                    </ul>
                </li>
              
                
                <!--setting-->
                <li>
                    <a href="setting" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-cog" aria-hidden="true"></i><span class="mtext">Setting</span>
                    </a>
                </li>
                
          
             
            </ul>
        </div>
    </div>
</div>