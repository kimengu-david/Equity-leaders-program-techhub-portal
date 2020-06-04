<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class=".d none">

<head>
    <!--<title>ELP techhub members</title>-->
</head>

<body>

    @foreach($details as $detail)
    <b>
        <div>Meetup Venue: {{$detail->Venue}}</div>
    </b>
    <b>
        <div>Meetup Date: {{$detail->Date}}</div>
    </b>
    <b>
        <div>Meetup Time: {{$detail->Time}}</div>
    </b>
    </br>
    </br>
    <b>Attendees List</b>

    @endforeach
    <table>

        <thead>

            <tr>
                <th>No.</th>
                <th>first Name</th>
                <th>Last Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $user)
            <tr>
                <td>{{ $loop->index+1 }}</td>
                <td>{{ $user->fname }}</td>
                <td>{{ $user->lname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->cont }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</body>

</html>