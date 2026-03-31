<div class="dashbord-sidebar">
        <ul>
            <li class="heading">Manage Account</li>
            <li><a class="@yield('profile')" href="{{route('employer.profile')}}"><i class="lni lni-clipboard"></i>Profile</a>
            </li>
            <li><a class="@yield('jobs')" href="{{route('employer.job.index')}}"><i class="lni lni-bookmark"></i> Jobs</a></li>
            <li><a class="@yield('jobfair')" href="{{route('employer.job-fair.index')}}"><i class="lni lni-calendar"></i> Job Fair</a></li>
                {{-- <li><a href="manage-applications.html"><i class="lni lni-envelope"></i> Manage
                    Applications</a></li>
                    <li><a href="manage-resumes.html"><i class="lni lni-files"></i> Manage Resumes</a></li>
                    <li><a href="job-alerts.html"><i class="lni lni-briefcase"></i> Job Alerts</a></li>
                    <li><a href="change-password.html"><i class="lni lni-lock"></i> Change Password</a></li>
                    <li><a href="index.html"><i class="lni lni-upload"></i> Sign Out</a></li> --}}
                </ul>
</div>