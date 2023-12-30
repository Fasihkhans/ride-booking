@props(['name'])
<div class="py-2 bg-white header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="py-1 row align-items-center">
                <div class="col-lg-6 col-7">
                    <h6 class="mb-0 h2 d-inline-block">{{$name}}</h6>
                </div>
                <div class="text-right col-lg-6 col-5">
                    {{$slot}}
                </div>
            </div>
        </div>
    </div>
</div>
