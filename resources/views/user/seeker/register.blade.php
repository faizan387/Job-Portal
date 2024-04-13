@extends('layouts.app')

@section('title', 'Register Seeker')

@section('content')

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Looking for a job?</h1>
            <h3>Please create an account</h3>
            <img src="{{asset('image/register.png')}}" alt="" />
        </div>
        <div class="col-md-6">
            <div class="card" id="card">
                <div class="card-header">Register</div>
                <form action="#" method="POST" id="seekerRegistrationForm">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" class="form-control" required/>
                            @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" class="form-control" required/>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required/>
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <br />
                        <div class="form-group">
                            <button class="btn btn-primary" id="seekerRegistrationBtn">Register</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="message"></div>
        </div>
    </div>
</div>

<script>
    // on click of register button
    let registerBtn = document.getElementById('seekerRegistrationBtn').addEventListener("click", function(evt) {
        let url = "{{route('store.seeker')}}";
        let form = document.getElementById('seekerRegistrationForm');
        let card = document.getElementById('card');
        let messageDiv = document.getElementById('message');
        messageDiv.innerHTML = '';
        let formData = new FormData(form);
        let btn = evt.target;
        // disable the register button and change its text
        btn.disabled = true;
        btn.innerHTML = 'Sending email ...';
        // send the post API request
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            body: formData
        }).then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error');
            }
        }).then(data => {
            // on creation, hide the form & show a success message
            btn.innerHTML = 'Register';
            btn.disabled = false;
            messageDiv.innerHTML =
            '<div class="alert alert-success">Registration was successful. Kindly check your email to verify it</div>';
            card.style.display = 'none';
        }).catch(error => {
            console.log(error);
            // else show the form with an error message
            btn.innerHTML = 'Register';
            btn.disabled = false;
            messageDiv.innerHTML =
            '<div class="alert alert-danger">Something went wrong. Kindly try again</div>';
        })
    })
</script>

@endsection