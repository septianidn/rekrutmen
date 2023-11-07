<x-front-office-layout :assets="$assets ?? []">





    <section class="hero-area style3">
        <!-- Single Slider -->
        <div class="hero-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 co-12">
                        <div class="inner-content">
                            <img src="{{ asset('images/frontoffice/tracerstudy/hero.jpg') }}" alt="#"
                                class="img-fluid mt-4">

                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-0 col-md-8 offset-md-2 co-12">
                        {{ Form::open(['class' => 'home-search wow fadeInRight', 'data-wow-delay' => '.5s', 'method' => 'POST']) }}
                        <h3 class="mb-2">Login Tracer Study Lulusan {{ $untuk_lulusan }}</h3>
                        <p class="mb-2">Silahkan login pada form dibawah ini untuk dapat mengakses survey tracer
                            study. Apabila anda mengalami kesulitan dalam login, silahkan hubungi Administrator Tracer
                            Study</p>


                        <x-auth-validation-errors class="mb-2 mt-3" :errors="$errors" />
                        {{ Form::hidden('untuk_lulusan', $untuk_lulusan, ['class' => 'form-control']) }}
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">PIN</label>
                            <div class="form-location">
                                {{ Form::text('pin', '', ['class' => 'form-control', 'placeholder' => 'Masukkan PIN', 'required']) }}
                                <small class="mt-2">Gunakan PIN yang telah dikirimkan lewat email untuk masuk.</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">Captcha</label>
                            <div class="form-location">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        </div>
                        <div class="checkbox mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat Saya
                                </label>
                            </div>
                        </div>
                        <div class="button">
                            <button class="btn btn-primary" type="submit"> Masuk </a>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-front-office-layout>

<script type="text/javascript">
    $('#reload').click(function() {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function(data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
