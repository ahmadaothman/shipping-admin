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
                <!--Region-->
                <li>
                    <a href="/regions" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-map-o" aria-hidden="true"></i><span class="mtext">Regions</span>
                    </a>
                </li>
                   <!--Region-->
                   <li>
                    <a href="/cities" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-map" aria-hidden="true"></i></i><span class="mtext">Cities</span>
                    </a>
                </li>
                <!--users-->
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <i class="icon-copy fa fa-user-circle" aria-hidden="true"></i> Users</span>
                    </a>
                    <ul class="submenu">
                    
                        <li><a href="/users?user_type_id=3"><i class="icon-copy fa fa-user-circle-o" aria-hidden="true"></i> Admin</a></li><a href="/users?user_type_id=3">
                        </a><li><a href="/users?user_type_id=3"></a><a href="/users?user_type_id=4"><i class="icon-copy fa fa-keyboard-o" aria-hidden="true"></i> Data Entry</a></li><a href="/users?user_type_id=4">
                        </a><li><a href="/users?user_type_id=4"></a><a href="/users?user_type_id=5"><i class="icon-copy fa fa-archive" aria-hidden="true"></i> Ware House</a></li><a href="/users?user_type_id=5">
                        </a><li><a href="/users?user_type_id=5"></a><a href="/users?user_type_id=6"><i class="icon-copy fa fa-money" aria-hidden="true"></i> Accounting</a></li><a href="/users?user_type_id=6">
                        </a><li><a href="/users?user_type_id=6"></a><a href="/users?user_type_id=7"><i class="icon-copy fa fa-motorcycle" aria-hidden="true"></i> Driver</a></li><a href="/users?user_type_id=7">
                </a></ul>
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
                    <a href="/setting" class="dropdown-toggle no-arrow">
                        <i class="icon-copy fa fa-cog" aria-hidden="true"></i><span class="mtext">Setting</span>
                    </a>
                </li>
                
          
             
            </ul>
        </div>
    </div>
</div>