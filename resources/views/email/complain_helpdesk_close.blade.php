<html>

<body>
<h2>Aduan telah ditutup. No Aduan: {{ $complain_id }} </h2>
<p>Assalamualaikum @foreach($rcptname as $iname)nama:{{ $iname }}<br>@endforeach<br>
Terdapat aduan ditutup:<br>
No Aduan:{{ $complain_id }}<br>
Perihal Aduan:{{ $complain_description }}
</p>
<p>Sila rujuk sistem Aduan ICT</p>

<p>-Emel ini dijana secara otomatik dari Sistem</p>
</body>
</html>