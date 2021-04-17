@php
    $headers = isset($headers) ? $headers : array_keys($data->toArray()[0]);
    $values = isset($values) ? $values : [];
@endphp

<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
<thead>
    <tr>
        <th>No</th>
        @foreach ($headers as $key => $item)
            <th>{{ $item }}</th>
        @endforeach
        @isset($actions)
            <th>Aksi</th>
        @endisset
    </tr>
</thead>
<tbody>
    @foreach ($data as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            @foreach ($headers as $key2 => $item2)
                <td>
                    @if (array_key_exists($key2, $values))
                        {{ $values[$key2]($item) }}
                    @else
                        {{ $item[$key2] ? $item[$key2] : "-"}}
                    @endif
                </td>
            @endforeach
            @isset($actions)
                <td>
                    @foreach ($actions as $a => $aksi)
                        @php
                            $url = route($aksi['url'], $item->id);
                        @endphp
                        <a href="{{ $url }}">
                            @isset($aksi['attribute'])
                                <span class="badge badge-boxed badge-pill badge-outline-{{ $aksi['button'] }}">
                                    @foreach ($aksi['attribute'] as $key => $attr)
                                        @if ($key == 'icon')
                                            <i class="{{ $attr }}"></i>
                                        @endif    
                                    @endforeach
                                </span>
                            @endisset
                        </a>
                    @endforeach
                </td>
            @endisset           
        </tr>
    @endforeach
</tbody>
</table>