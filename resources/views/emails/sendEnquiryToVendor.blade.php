<style>p{font-size: 15px;}</style>
<div>
    <p>Hi {{ $vendor_name }},</p>

    <p>You have receive a new request for following ad:</p>
    <p>Ad Title: <b>{{ $ad_title }}</b></p>
    <p>Category: <b>{{ $cat_name }}
        @if($sub_cat_name != '')
        > {{ $sub_cat_name }}
        @endif
    </b></p>
</div>
<div style="margin-top: 20px;">
    <h3>Customer Details as follow:</h3>
    <p>Name: <b>{{ $name }}</b></p>
    <p>Email: <b>{{ $email }}</b></p>
    <p>Mobile Number: <b>{{ $phone }}</b></p>
    <p>Message: <b>{{ $ad_message }}</b></p>
</div>
<div style="margin-top: 30px;">
    <p>Thankyou.</p>
</div>