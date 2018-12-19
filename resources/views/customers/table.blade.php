<table class="table table-responsive" id="customers-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Added On</th>
        </tr>
    </thead>
    <tbody>
    @foreach($customers as $customer)
        <tr class="customer-data-rows">
            <td>{!! $customer->name !!}</td>
            <td>{!! $customer->email !!}</td>
            <td>{!! $customer->phone !!}</td>
            <td>{!! date('d M, Y H:i:s', strtotime($customer->added_on)) !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $customers->render() }}