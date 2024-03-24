<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student_trash</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container-xl">
    <div class="my-3">
            <a href="/dashboard" class="btn btn-primary">Dashboard</a>
        </div>
    <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Courses</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($trashedstudents as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->contact }}</td>
                    <td>
                        @foreach($student->courses as $course)
                            {{ $loop->first ? '' : ', ' }}
                            {{ $course->title }}
                        @endforeach
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="/students/restore/{{ $student->id }}" class="btn btn-success m-1">Restore</a>
                            @csrf
            @method('DELETE')
            <button class="btn btn-danger m-1" onclick="destroy({{ $student->id }})">Delete</button>

                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
       
            <!-- </tbody> -->
        </table>
    </div>

<script>
$(document).ready(function() {
    student_trash();
});

function student_trash() {
    $.ajax({
        method: 'get',
        url: '/student_trash',
        // dataType: 'json',
        success: function(response) {
            if (Array.isArray(response)) {
                var tr = '';
                response.forEach(function(student) {
                    tr += '<tr>';
                    tr += '<td>' + student.id + '</td>';
                    tr += '<td>' + student.name + '</td>';
                    tr += '<td>' + student.email + '</td>';
                    tr += '<td>' + student.address + '</td>';
                    tr += '<td>' + student.contact + '</td>';
                    var coursesList = student.courses.map(function(course) {
                        return course.title;
                    }).join(", ");
                    tr += '<td>' + coursesList + '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<button class="btn btn-success m-1" onclick="restoreStudent(' + student.id + ')">Restore</button>';
                    tr += '<button class="btn btn-danger m-1" onclick="destroy(' + student.id + ')">Delete</button>';
                    tr += '</div></td>';
                    tr += '</tr>';
                });
            $('#studentsList').html(tr);}else {
                console.error('Response is not an array:', response);
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function restoreStudent(id) {
    
    if(confirm("Are you sure you want to restore this student?")) {
        $.ajax({
            method: 'post',
            url: '/students/restore/' + id,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), 
                id: id 
            },
            success: function(response) {
                alert("Student restored successfully");
                student_trash(); 
            },
            error: function(xhr) {
                alert(`Error: ${xhr.responseText}`);
            }
        });
    }
}

function destroy (id) {
    if(confirm("Are you sure you want to delete this student?")) {
        $.ajax({
            method: 'DELETE',
            url: '/students/delete/' + id,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), 
                
            },
            success: function(response) {
                alert("Student deleted successfully");
                student_trash(); 
            },
            error: function(xhr) {
                console.log(xhr.status); 
    console.log(xhr.responseText);
                alert(`Error: ${xhr.responseText}`);
            }
        });
    }
}
    


// function deleteStudent(id) {
//     if(confirm("Are you sure you want to delete this student?")) {
//         $.ajax({
//             type: 'post',
//             data: { id: id, _token: "{{ csrf_token() }}" },
//             url: '/student-delete/' + id,
//             success: function(response) {
//                 alert("Student deleted successfully");
//                 studentList(); 
//             },
//             error: function(xhr) {
//                 alert(`Error: ${xhr.responseText}`);
//             }
//         });
//     }

</script>

</body>
</html>