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

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>

<table id="customers">
  <tr>
    <th>Company</th>
    <th>Contact</th>
  </tr>
  <tr>
    <td>Name</td>
    <td>{{$request->name }}</td>
  </tr>
  <tr>
    <td>Email</td>
    <td>{{$request->email }}</td>
  </tr>
  <tr>
    <td>Mobile</td>
    <td>{{$request->mobile }}</td>
  </tr>
  <tr>
    <td>Message</td>
    <td>{{$request->message }}</td>
  </tr>


</table>

</body>
</html>
