Welcome to laravel-admin
<table class="table table-striped">

    @foreach($infos as $env)
    <tr>
        <td width="120px">{{ $env['name'] }}</td>
        <td>{{ $env['value'] }}</td>
    </tr>
    @endforeach
</table>