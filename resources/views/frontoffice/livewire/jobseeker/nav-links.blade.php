<div class="col-lg-4 col-12">
    
                        <div class="dashbord-sidebar">
                            <ul>
                                <li class="heading">Manage Account</li>
                                <x-sidebar-link :href="route('jobseeker.profile.riwayat-pendidikan')" :active="request()->routeIs('jobseeker.profile.riwayat-pendidikan')">
                                    <i class="lni lni-bookmark"></i> Riwayat Pendidikan
                                </x-sidebar-link>
                                <li><a href="bookmarked.html"><i class="lni lni-bookmark"></i> Bookmarked Jobs</a></li>
                                <li><a href="notifications.html"><i class="lni lni-alarm"></i> Notifications <span
                                            class="notifi">5</span></a></li>
                                <li><a href="manage-applications.html"><i class="lni lni-envelope"></i> Manage
                                        Applications</a></li>
                                <li><a href="manage-resumes.html"><i class="lni lni-files"></i> Manage Resumes</a></li>
                                <li><a href="job-alerts.html"><i class="lni lni-briefcase"></i> Job Alerts</a></li>
                                <li><a href="change-password.html"><i class="lni lni-lock"></i> Change Password</a></li>
                                <li><a href="index.html"><i class="lni lni-upload"></i> Sign Out</a></li>
                            </ul>
                        </div>

</div>
