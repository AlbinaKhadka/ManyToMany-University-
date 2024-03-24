
@extends('layout.web')
@section('content')
    <div class="container-xl">
        <div class="d-flex justify-content-between mb-2">
        <a href="{{ route('students.trash') }}" class="btn btn-danger">Trash</a>
        <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#trashStudentModal">Trash</button> -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">Add New Student</button>
            <input type="text" class="form-control w-auto" id="searchStudentInput" placeholder="Search students...">
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
            <tbody id="studentsList">
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->contact }}</td>
                    <td>{{ $student->courses->pluck('title')->join(', ') }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            <tbody>
           
        </tbody>
            
</table>
<div class="d-flex justify-content-center">
{!!$students->links()!!}
</div>
</div>
        <div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog">

            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        
                    </div>
                    
                    <div class="modal-body">
                        <form id="addStudentForm">
                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" class="form-control" id="addStudentName" name="name" required>
                            </div>
                            <div class="form-group">
                                <label>Email:</label>
                                <input type="email" class="form-control" id="addStudentEmail" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Address:</label>
                                <input type="text" class="form-control" id="addStudentAddress" name="address" required>
                            </div>
                            <div class="form-group">
                                <label>Contact:</label>
                                <input type="text" class="form-control" id="addStudentContact" name="contact" required>
                            </div>
                            <div class="form-group">
                                <label>Course:</label>
                                <?php
                                    $courses = App\Models\Course::all();
                                ?>
                                <select id="course" style="width:200px;" name="course[]" multiple required>
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                    <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <button type="button" id="addStudentButton" class="btn btn-primary">Add New Student</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
<div id="editStudentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editStudentForm">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Student</h4>   

                </div>
                <div class="modal-body">
                <input type="hidden" id="editStudentId" name="id" >
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" id="editStudentName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" class="form-control" id="editStudentEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <input type="text" class="form-control" id="editStudentAddress" name="address" required>
                    </div>
                    <div class="form-group">
                        <label>Contact:</label>
                        <input type="text" class="form-control" id="editStudentContact" name="contact" required>
                    </div>
                    
                    <div class="form-group">
                                <label>Course:</label>
                                <?php
                                    $courses = App\Models\Course::all();
                                ?>
                                <select id="course" style="width:200px;" name="course[]" multiple required>
                                    <option value="">Select a course</option>
                                    @foreach($courses as $course)
                                    <option value="{{$course->id}}">{{$course->title}}</option>
                                    @endforeach
                                </select>
                                
    </div>
    
</div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<div id="deleteStudentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteStudentForm">
                <div class="modal-header">
                    <h4 class="modal-title">Archive Student</h4> 
                </div>
                <div class="modal-body">
                <p>Are you sure you want to archive this student? </p>
                
                    <input type="hidden" id="deleteStudentId" name="id">
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-warning" value="Archive">
                </div>
            </form>
        </div>
    </div>
</div>


<div id="viewStudentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Student</h4>
                <button class="viewStudent" data-id="STUDENT_ID">View Student</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name:</label>
                    <p id="viewStudentName"></p>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <p id="viewStudentEmail"></p>
                </div>
                <div class="form-group">
                    <label>Address:</label>
                    <p id="viewStudentAddress"></p>
                </div>
                <div class="form-group">
                    <label>Contact:</label>
                    <p id="viewStudentContact"></p>
                </div>
                <div class="form-group">
                    <label>Course:</label>
                    <p id="viewStudentCourse"></p>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
 
    @push('scripts')
    <script>
    $(document).ready(function() {
        $('#course').select2();

        studentList();
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    });
  

    function studentList(page=1) {
        $.ajax({
            type: 'get',
            url:  "{{ url('studentList') }}",
            success: function(response) {
                // console.log(response);
                var tr = '';
                response.data.forEach(function(student) {
                    tr += '<tr>';
                    tr += '<td>' + student.id + '</td>';
                    tr += '<td>' + student.name + '</td>';
                    tr += '<td>' + student.email + '</td>';
                    tr += '<td>' + student.address + '</td>';
                    tr += '<td>' + student.contact + '</td>';
                    // tr += '<td>';
                    // student.courses.forEach(function(course) {
                    //     tr += '<span>' + course.title+ '</span>; ';
                    // });
                    var coursesList = student.courses.map(function(course) {
                    return course.title;
                }).join(", ");
                tr += '<td>' + coursesList + '</td>';
                    tr += '</td>';
                    tr += '<td><div class="d-flex">';
                    tr += '<a href="" class="m-1 view" data-toggle="modal"data-target="#viewStudentModal" onclick="viewStudent(' + student.id + ')"><i class="fa fa-eye" data-toggle="tooltip" title="View">&#xf06e;</i></a>';
                    tr += '<a href="" class="m-1 edit" data-toggle="modal" data-target="#editStudentModal" onclick="editStudent(' + student.id + ')"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>';
                    
                    tr += '<a href="" class="m-1 delete" data-toggle="modal"data-target="#deleteStudentModal" onclick="deleteStudent('+student.id+')"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>';
                    tr += '</div></td>';
                    tr += '</tr>';
                });
                
                $('#studentsList').html(tr);
               
            },
            error: function(error) {
            console.log(error);
        }

        });
    }
    $('#addStudentButton').click(function(e) {
            e.preventDefault(); 
            addStudent(); 
        });
    function addStudent() {
        var formData = new FormData($('#addStudentForm')[0]);
        $.ajax({
            type: 'post',
            data: formData,
            url:  '/add-students',
            contentType: false, 
            processData: false,
            success: function(response) {
                studentList();
                alert(response.message);
                $('#addStudentModal').hide();
            },
            error: function(xhr, status, error) {
    console.error(xhr.responseText);
    alert(`Error: ${xhr.responseText}`);
}

        });
    }

    $('.editStudent').click(function() {
    var studentId = $(this).data('id');
    console.log(studentId);
    $.ajax({
        url: '/get-students/' + studentId,
        method: 'GET',
        success: function(response) {
            $('#editStudentId').val(response.id);
            $('#editStudentName').val(response.name);
            $('#editStudentEmail').val(response.email);
            $('#editStudentAddress').val(response.address);
            $('#editStudentContact').val(response.contact);
            var coursesSelect = $('#edit_courses');
            coursesSelect.empty(); 
            response.courses.forEach(function(course) {
                var option=new Option(course.title, course.id, true, true);
                coursesSelect.append(option).trigger('change');
            });
            coursesSelect.trigger('change');
            $('#editStudentModal').modal('show');
        },
        error: function(error) {
            console.error('Error fetching student data:', error);
        }
    });
});


                

//    var selectedCourses = $('#edit_courses').val(); 
//     var formData = {
//         name: $('#editStudentName').val(), 
//         email: $('#editStudentEmail').val(),
//         address: $('editStudentAddress').val(),
//         contact: $('#editStudentContact').val(),
//         id: $('#editStudentId').val(),
//         courses: selectedCourses, 
//     };

//     $.ajax({
//         type: 'get',
//         data: formData,
//         url: '/edit-student/'+studentId, 
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
            
//             alert(response.message);
//             $('#editStudentModal').modal('hide');
//             // $('#editStudentModal').hide();
//             studentList();
//         },
//         error: function(xhr) {
        
//             alert(`Error: ${xhr.responseText}`);
//         }
//     });
// }

    // function editStudents(id){
    //     console.log(id);
    //     $('#editStudentModal').modal('show');
    // }

    function viewStudent(id) {
        $.ajax({
            type: 'get',
            data: { id: id },
            url: `{{ url('get-students')}}/${id}`,
            success: function(response) {
                $('#viewStudentName').text(response.name);
                $('#viewStudentEmail').text(response.email);
                $('#viewStudentAddress').text(response.address);
                $('#viewStudentContact').text(response.contact);
                var coursesList = '';
                response.courses.forEach(function(course) {
                    coursesList += course.title + '; ';
                });
                $('#viewStudentCourse').text(coursesList);
                $('#viewStudentModal').modal('show');
            },
            error: function(xhr, status, error) {
    console.error(xhr.responseText);
    alert(`Error: ${xhr.responseText}`);
}

        });
    }

function deleteStudent(id) {
    //var id = $('#deleteStudentId').val(); 

    $.ajax({
        method: 'delete',
        url:'delete-students/'+id, 
        data: { _token: $('meta[name="csrf-token"]').attr('content')}, 
        success:function(response) {
            // alert('a');
            $('#deleteStudentModal').modal('hide'); 
            studentList(); 
            alert("Student has been successfully archived."); 
        }, 
        error:function(xhr, status, error) {
            // alert('b');
            console.error(error);
            alert('An error occurred while archiving the student.'); 
        }
    });
}

</script>
@endpush

</body>
</html>
