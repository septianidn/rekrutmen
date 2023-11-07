<x-front-office-layout :assets="$assets ?? []">
    <section class="section">
        <div class="container">
            <div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card mt-40">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">
                                    <h4 class="card-title">Tracer Study 2022</h4>
                                </div>
                            </div>
                            <div class="card-body">
                            </div>

                        </div>
                        <div class="card mt-40">
                            <div class="card-header d-flex justify-content-between">
                                <div class="header-title">

                                </div>
                            </div>
                            <div class="card-body">
                                <ul id="top-tab-list" class="p-0 row list-inline">
                                    <li class="col-lg-3 col-md-6 text-start mb-2 active" id="account">
                                        <a href="javascript:void();">
                                            <div class="iq-icon me-3">
                                                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="20"
                                                    width="20" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <span>Account</span>
                                        </a>
                                    </li>
                                    <li id="personal" class="col-lg-3 col-md-6 mb-2 text-start">
                                        <a href="javascript:void();">
                                            <div class="iq-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span>Personal</span>
                                        </a>
                                    </li>
                                    <li id="payment" class="col-lg-3 col-md-6 mb-2 text-start">
                                        <a href="javascript:void();">
                                            <div class="iq-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <span>Image</span>
                                        </a>
                                    </li>
                                    <li id="confirm" class="col-lg-3 col-md-6 mb-2 text-start">
                                        <a href="javascript:void();">
                                            <div class="iq-icon me-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span>Finish</span>
                                        </a>
                                    </li>
                                </ul>
                                <!-- fieldsets -->
                                <fieldset>
                                    @if ($paket_soal)
                                        {!! $paket_soal->deskripsi !!}
                                    @endif

                                    <button type="button" name="next"
                                        class="btn btn-primary next action-button float-end"
                                        value="Next">Selanjutnya</button>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>
    </section>

</x-front-office-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>


<script>
    /* 
        PAGE LISTENER 
    */

    $(document).ready(function() {





    });
</script>
