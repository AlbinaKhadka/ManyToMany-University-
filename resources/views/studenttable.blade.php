<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Form</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="form-container">
    <form id="studentForm">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <div class="form-group">
            <label for="contact">Contact:</label>
            <input type="text" id="contact" name="contact" required>
        </div>
        <div class="form-group">
            <label for="course">Course:</label>
            <select id="course" name="course" multiple required>
                <option value="">Select a course</option>
                <option value="1">BCA</option>
                <option value="2">BBS</option>
                <option value="3">BBM</option>
                <option value="4">BIT</option>
            </select>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // console.log('jQuery is working!');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#course').select2();
    $('#studentForm').submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: "{{route('add.student')}}",
            type: "POST",
            data: {
                name: $('#name').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                contact: $('#contact').val(),
                course: $('#course').val()
            },
            success:function(response) {
                console.log(response);
                //alert(response.success);
            },
            error: function(xhr) {
                console.log(xhr);
                // if (xhr.status === 422) {
                //     const errors = xhr.responseJSON.errors;
                //     let errorMessage = '';
                //     Object.keys(errors).forEach((key) => {
                //         errorMessage += `${key}: ${errors[key].join(', ')}\n`;
                //     });
                //     alert(errorMessage);
                // } else {
                //     alert('An error occurred.');
                // }
            }
        });
    });
});
</script>
</body>
</html>
