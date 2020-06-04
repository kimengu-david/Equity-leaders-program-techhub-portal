<!DOCTYPE html>
<html lang="en" class=".d none">

<head>

</head>

<body>
    <header class="clearfix">

        <div>Account for : {{$fullname}}</div>
        <div>Statement As At: {{$date}}</div>
        </div>

    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Transaction Details </th>
                    <th>Type</th>
                    <th>Posted by </th>


                </tr>
            </thead>
            <tbody>
                @foreach ($statements as $statement)
                <tr>
                    <td class="desc">{{ $statement->id }}</td>
                    <td class="total">{{ $statement->amount }}</td>

                    <td class="total">{{ $statement->transaction_details }}</td>

                    <td class="total">{{ $statement->Type }}</td>
                    <td class="total">{{ $statement->posted_by }}</td>
                </tr>
                @endforeach


            </tbody>
        </table>
        <!--Payment Terms -->
        <div id="notices">
            <div class="notice"><strong>Available Balance Ksh.{{$current_balance}}</strong></div>
        </div>
        <!--Bank details -->

    </main>
    <footer>
        Statement was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>