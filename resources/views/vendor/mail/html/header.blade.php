@props(['url'])
<tr>
<td class="header" align="center" style="padding: 24px 0; text-align: center;">
<a href="{{ $url ?? config('app.url') }}" target="_blank" style="display: inline-block;">
<img src="{{ url('assets/imgs/logo.png') }}" alt="Grandiya" width="120" height="auto" style="display: block; max-width: 120px; height: auto; margin: 0 auto;" />
</a>
</td>
</tr>
