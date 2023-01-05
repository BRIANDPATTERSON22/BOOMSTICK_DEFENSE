<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Email</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody>
    <?php $count = 0; ?>
    @foreach ($allData as $row)
        <?php $count++; ?>
        <tr>
            <td>{{$count}}</td>
            <td>{{$row->email}}</td>
            <td>{!!$row->created_at!!}</td>
        </tr>
    @endforeach
    </tbody>
</table>