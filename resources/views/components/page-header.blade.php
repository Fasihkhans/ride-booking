@props(['name'])
<div class="header bg-white p-4">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 d-inline-block mb-0">{{$name}}</h6>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
