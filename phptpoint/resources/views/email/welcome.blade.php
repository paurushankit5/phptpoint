<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}


#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.btn{
      display: inline-block;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    border-radius: 4px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    text-decoration:none;
}
a{
  color:#fff;
}
</style>
</head>
<body>

<table id="customers">
  <tr>
    <th colspan="2" style="text-align: center"><h1>{{ env('APP_NAME') }}</h1></th>
  </tr>
  <tr>
    <td colspan="2" style="text-align: center">
      <h1>Hello {{$user->name}}, </h1>
      <p>Please click the button below to verify your email address.</p>
      <a href="{{ env('APP_URL') }}/user/verify/{{ $user->id }}" style="color: white;" type="button" class="btn">Click Here</a>
      <p>If you did not create an account, no further action is required.</p>
      <br>
      <p>Regards,</p>
      <p>{{ env('APP_NAME') }}</p>


    </td>
  </tr>
  


</table>

</body>
</html>
