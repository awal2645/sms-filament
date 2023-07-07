<!DOCTYPE html>
<html>
<head>
    <title>Laravel Filament PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">{{ $title }}</h1>
    <p class="text-center">{{ $date }}</p>
  
    <table class="table table-bordered">
        <tr>
            <th>Roll</th>
            <th>Name</th>
            <th>Class</th>
            <th>Section</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Adress</th>
        </tr>
        
        <tr>
            <td>{{ $users->id }}</td>
            <td>{{ $users->name }}</td>
            <td>{{ $users->class->name }}</td>
            <td>{{ $users->section->name }}</td>
            <td>{{ $users->email }}</td>
            <td>{{ $users->phone_number }}</td>
            <td>{{ $users->address }}</td>
        </tr>
       
    </table>
  
</body>