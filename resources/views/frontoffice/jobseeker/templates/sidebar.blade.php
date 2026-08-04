<div class="dashbord-sidebar">
        <ul>
            <li class="heading">Kelola Akun</li>
            <x-sidebar-link :href="route('jobseeker.index')" :active="request()->routeIs('jobseeker.index')">
                <i class="lni lni-clipboard"></i>Beranda
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.profile')" :active="request()->routeIs('jobseeker.profile')">
                <i class="lni lni-bookmark"></i>Profil
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.jobs')" :active="request()->routeIs('jobseeker.jobs')">
                <i class="lni lni-briefcase"></i>Lowongan
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.my-applications')" :active="request()->routeIs('jobseeker.my-applications')">
                <i class="lni lni-envelope"></i>Lamaran Saya
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.job-fair.index')" :active="request()->routeIs('jobseeker.job-fair.*')">
                <i class="lni lni-calendar"></i>Job Fair
            </x-sidebar-link>
        </ul>
</div>
