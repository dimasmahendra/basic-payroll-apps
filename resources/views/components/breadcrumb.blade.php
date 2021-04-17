@php
    $item = isset($breadcrumbs) ? $breadcrumbs : [];
@endphp
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">{{isset($title) ? $title : ""}}</h4>
                    <ol class="breadcrumb">
                        @foreach ($item as $value)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $value['label'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $value['url'] }}">{{ $value['label'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
            <!--end row-->
        </div>
        <!--end page-title-box-->
    </div>
    <!--end col-->
</div>
<!--end row--><!-- end page title end breadcrumb -->