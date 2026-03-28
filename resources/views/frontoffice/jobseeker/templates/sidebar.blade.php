<div class="dashbord-sidebar">
        <ul>
            <li class="heading">Manage Account</li>
            <x-sidebar-link :href="route('jobseeker.index')" :active="request()->routeIs('jobseeker.index')">
                <i class="lni lni-clipboard"></i>Home
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.profile')" :active="request()->routeIs('jobseeker.profile')">
                <i class="lni lni-bookmark"></i>Profile
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.jobs')" :active="request()->routeIs('jobseeker.jobs')">
                <i class="lni lni-clipboard"></i>Jobs
            </x-sidebar-link>
            <x-sidebar-link :href="route('jobseeker.index')" :active="request()->routeIs('')">
                <i class="lni lni-alarm"></i>Applications <span
                class="notifi">5</span>
            </x-sidebar-link>
        </ul>
</div>