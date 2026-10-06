@extends('frontend.layouts.app')


@section('content')


    <div class="breadcumb-wrapper " data-bg-src="{{ url('assets/frontend/img/breadcumb/breadcumb-bg.jpg') }}">
        <div class="container z-index-common">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact Us</h1>
                <p class="breadcumb-text">Learning Today for a Better Tomorrow</p>
                <div class="breadcumb-menu-wrap">
                    <ul class="breadcumb-menu">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!--==============================
    Contact Area
    ==============================-->
    <section class=" space-top space-extra-bottom ">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="{{ url('assets/frontend/img/icon/c-b-1-1.svg') }}" alt="icon"></div>
                        <h3 class="info-title">Phone No</h3>
                        <p class="info-text"><a href="tel:+4402076897888" class="text-inherit">+977-25-525300</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="{{ url('assets/frontend/img/icon/c-b-1-2.svg') }}" alt="icon"></div>
                        <h3 class="info-title">Monday to Friday</h3>
                        <p class="info-text">7:00 am - 5:30 pm</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-style2">
                        <div class="info-icon"><img src="{{ url('assets/frontend/img/icon/c-b-1-3.svg') }}" alt="icon"></div>
                        <h3 class="info-title">Email Address</h3>
                        <p class="info-text"><a href="mailto:kkisdharan@gmail.com" class="text-inherit">kkisdharan@gmail.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section><!--==============================
    Contact Area
    ==============================-->
    <section class=" space-extra-bottom ">
        <div class="container">
            <div class="row flex-row-reverse gx-60 justify-content-between">
                <div class="col-xl-auto">
                    <img src="{{ url('assets/frontend/img/about/con-2-1.png') }}" alt="girl" class="w-100">
                </div>
                <div class="col-xl col-xxl-6 align-self-center">
                    <div class="title-area">
                        <span class="sec-subtitle">Have Any questions? so plese</span>
                        <h2 class="sec-title">Feel Free to Contact!</h2>
                    </div>
                    <form class="form-style3 layout2" id="enquiryForm" novalidate>
    @csrf
    <div class="row justify-content-between">
 
        <div class="col-md-6 form-group mb-3">
            <label for="firstname">First Name <span class="required">*</span></label>
            <input name="firstname" id="firstname" type="text" class="form-control" placeholder="Enter first name" required />
            <div class="invalid-feedback">Please enter your first name.</div>
        </div>
 
        <div class="col-md-6 form-group mb-3">
            <label for="lastname">Last Name <span class="required">*</span></label>
            <input name="lastname" id="lastname" type="text" class="form-control" placeholder="Enter last name" required />
            <div class="invalid-feedback">Please enter your last name.</div>
        </div>
 
        <div class="col-md-6 form-group mb-3">
            <label for="email">Email Address <span class="required">*</span></label>
            <input name="email" id="email" type="email" class="form-control" placeholder="example@email.com" required />
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>
 
        <div class="col-md-6 form-group mb-3">
            <label for="number">Phone Number <span class="required">*</span></label>
            <input name="number" id="number" type="tel" class="form-control" placeholder="Enter phone number" required />
            <div class="invalid-feedback">Please enter your phone number.</div>
        </div>
 
        <div class="col-12 form-group mb-3">
            <label for="message">Message <span class="required">*</span></label>
            <textarea name="message" id="message" cols="30" rows="6"
                      class="form-control" placeholder="Type your message here..." required></textarea>
            <div class="invalid-feedback">Please enter your message.</div>
        </div>
 
        <div class="col-auto form-group">
            <button class="vs-btn" type="submit" id="submitBtn">
                <span id="btnText">Send Message</span>
                <span id="btnSpinner" class="d-none">
                    <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                    Sending...
                </span>
            </button>
        </div>
 
        {{-- Alert message area --}}
        <div class="col-12 mt-3">
            <div id="formAlert" class="alert d-none" role="alert"></div>
        </div>
 
    </div>
</form>
                </div>
            </div>
        </div>
    </section><!--==============================
    Map Area
    ==============================-->
    <section class=" space-bottom">
        <div class="container">
            <div class="title-area">
                <h2 class="mt-n2">How To Find Us</h2>
            </div>
            <div class="map-style1">
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113965.16364660284!2d87.19370835326166!3d26.795027356337794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39ef419fc7271c1d%3A0x1d1300367590c002!2sDharan%2C%20Nepal!5e0!3m2!1sen!2sin!4v1780571773498!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    
    
    <script>
document.getElementById('enquiryForm').addEventListener('submit', async function (e) {
    e.preventDefault();
 
    const form    = this;
    const btn     = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('btnSpinner');
    const alert   = document.getElementById('formAlert');
 
    // -- Client-side validation --------------------------------------
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }
    form.classList.remove('was-validated');
 
    // -- Loading state -----------------------------------------------
    btn.disabled = true;
    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    alert.classList.add('d-none');
 
    // -- Prepare data ------------------------------------------------
    const payload = new FormData(form);
 
    try {
        const response = await fetch("{{ route('enquiry.store') }}", {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept'      : 'application/json',
            },
            body: payload,
        });
 
        const result = await response.json();
 
        if (response.ok && result.success) {
            // -- Success ---------------------------------------------
            alert.className = 'alert alert-success';
            alert.innerHTML = `? <strong>Success!</strong> ${result.message}`;
            alert.classList.remove('d-none');
            form.reset();
            form.classList.remove('was-validated');
        } else {
            // -- Validation errors from Laravel ----------------------
            let errorHtml = '?? <strong>Please fix the following errors:</strong><ul class="mb-0 mt-1">';
            if (result.errors) {
                Object.values(result.errors).forEach(msgs => {
                    msgs.forEach(msg => { errorHtml += `<li>${msg}</li>`; });
                });
            } else {
                errorHtml += `<li>${result.message || 'Something went wrong. Please try again.'}</li>`;
            }
            errorHtml += '</ul>';
            alert.className = 'alert alert-danger';
            alert.innerHTML  = errorHtml;
            alert.classList.remove('d-none');
        }
 
    } catch (err) {
        alert.className = 'alert alert-danger';
        alert.innerHTML = '? <strong>Network error.</strong> Please check your connection and try again.';
        alert.classList.remove('d-none');
    } finally {
        // -- Restore button ------------------------------------------
        btn.disabled = false;
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
    }
});
</script>
   
@endsection
