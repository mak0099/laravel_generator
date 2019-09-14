<div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">Main</li>
                    <li class="{{ Request::is('dashboard') ? 'active' : null }}">
                        <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard </a>
                    </li>
                    <li class="{{ Request::is('crud-generator*') ? 'active' : null }}">
                        <a href="{{ route('crud_index') }}"><i class="fa fa-circle"></i> CRUD Generator </a>
                    </li>
                    <li class="{{ Request::is('dashboard/database*') ? 'active' : null }}">
                        <a href="{{ route('database.index') }}"><i class="fa fa-database"></i> DB Management </a>
                    </li>
                    {{-- <li>
                        <a href="chat.html"><i class="fa fa-comments" aria-hidden="true"></i> Chat <span class="badge bg-primary pull-right">5</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-video-camera camera" aria-hidden="true"></i> <span> Calls</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="voice-call.html">Voice Call</a></li>
                            <li><a href="video-call.html">Video Call</a></li>
                            <li><a href="incoming-call.html">Incoming Call</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i> <span> Email</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="compose.html">Compose Mail</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="mail-view.html">Mail View</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="contacts.html"><i class="fa fa-address-card" aria-hidden="true"></i> Contacts</a>
                    </li>
                    <li>
                        <a href="tasks.html"><i class="fa fa-tasks" aria-hidden="true"></i> Tasks</a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-commenting-o" aria-hidden="true"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="blog-details.html">Blog View</a></li>
                            <li><a href="add-blog.html">Add Blog</a></li>
                            <li><a href="edit-blog.html">Edit Blog</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="tickets.html"><i class="fa fa-ticket" aria-hidden="true"></i> Tickets</a>
                    </li>
                    <li>
                        <a href="settings.html"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                    </li>
                    <li class="menu-title">UI Elements</li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-laptop" aria-hidden="true"></i> <span> Components</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="uikit.html">UI Kit</a></li>
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="tabs.html">Tabs</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="widgets.html"><i class="fa fa-th" aria-hidden="true"></i> Widgets</a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-edit" aria-hidden="true"></i> <span> Forms</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="form-basic-inputs.html">Basic Inputs</a></li>
                            <li><a href="form-input-groups.html">Input Groups</a></li>
                            <li><a href="form-horizontal.html">Horizontal Form</a></li>
                            <li><a href="form-vertical.html">Vertical Form</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-table" aria-hidden="true"></i> <span> Tables</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="tables-basic.html">Basic Tables</a></li>
                            <li><a href="tables-datatables.html">Data Table</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="calendar.html"><i class="fa fa-calendar" aria-hidden="true"></i> Calendar</a>
                    </li>
                    <li class="menu-title">Extras</li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-columns" aria-hidden="true"></i> <span>Pages</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="login.html"> Login </a></li>
                            <li><a href="register.html"> Register </a></li>
                            <li><a href="forgot-password.html"> Forgot Password </a></li>
                            <li><a href="change-password2.html"> Change Password </a></li>
                            <li><a href="lock-screen.html"> Lock Screen </a></li>
                            <li><a href="profile.html"> Profile </a></li>
                            <li><a href="gallery.html"> Gallery </a></li>
                            <li> <a href="pricing.html">Pricing</a></li>
                            <li><a href="error-404.html">404 Error </a></li>
                            <li><a href="error-500.html">500 Error </a></li>
                            <li><a href="coming-soon.html">Coming Soon </a></li>
                            <li><a href="blank-page.html"> Blank Page </a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);" class="noti-dot"><i class="fa fa-rocket" aria-hidden="true"></i> <span>CRM </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="submenu">
                                <a href="#" class="noti-dot"><span> Employees</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li><a href="employees.html">All Employees</a></li>
                                    <li><a href="holidays.html">Holidays</a></li>
                                    <li><a href="leaves.html"><span>Leave Requests</span> <span class="badge bg-primary pull-right">1</span></a></li>
                                    <li><a href="attendance.html">Attendance</a></li>
                                    <li><a href="departments.html">Departments</a></li>
                                    <li><a href="designations.html">Designations</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="clients.html">Clients</a>
                            </li>
                            <li>
                                <a href="projects.html">Projects</a>
                            </li>
                            <li>
                                <a href="tasks.html">Tasks</a>
                            </li>
                            <li>
                                <a href="leads.html">Leads</a>
                            </li>
                            <li class="submenu">
                                <a href="#"><span> Accounts </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li><a href="estimates.html">Estimates</a></li>
                                    <li><a href="invoices.html">Invoices</a></li>
                                    <li><a href="payments.html">Payments</a></li>
                                    <li><a href="expenses.html">Expenses</a></li>
                                    <li><a href="provident-fund.html">Provident Fund</a></li>
                                    <li><a href="taxes.html">Taxes</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="#"><span> Payroll </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li><a href="salary.html"> Employee Salary </a></li>
                                    <li><a href="salary-view.html"> Payslip </a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="worksheet.html">Timing Sheet</a>
                            </li>
                            <li>
                                <a href="assets.html">Assets</a>
                            </li>
                            <li>
                                <a href="activities.html">Activities</a>
                            </li>
                            <li>
                                <a href="users.html">Users</a>
                            </li>
                            <li class="submenu">
                                <a href="#"><span> Reports </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled" style="display: none;">
                                    <li><a href="expense-reports.html"> Expense Report </a></li>
                                    <li><a href="invoice-reports.html"> Invoice Report </a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <span> Ecommerce </span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled" style="display: none;">
                            <li><a href="products.html"> Products </a></li>
                            <li><a href="products-list.html"> Products List </a></li>
                            <li><a href="product-details.html"> Product Details </a></li>
                            <li><a href="add-product.html"> Add Product </a></li>
                            <li><a href="edit-product.html"> Edit Product </a></li>
                            <li><a href="orders.html"> Orders </a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="javascript:void(0);"><i class="fa fa-share-alt" aria-hidden="true"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li class="submenu">
                                <a href="javascript:void(0);"><span>Level 1</span> <span class="menu-arrow"></span></a>
                                <ul style="display: none;">
                                    <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                    <li class="submenu">
                                        <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                                        <ul class="list-unstyled" style="display: none;">
                                            <li><a href="javascript:void(0);">Level 3</a></li>
                                            <li><a href="javascript:void(0);">Level 3</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0);"><span>Level 1</span></a>
                            </li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>