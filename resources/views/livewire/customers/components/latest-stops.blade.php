<div>
    <ul>
        @foreach ($stops as $stop)
            <li>{{ $stop }}</li> <!-- Adjust the display as per your model -->
        @endforeach
    </ul>
</div>
@script
<script>
    window.addEventListener('scroll', () => {
        let scrollPosition = window.innerHeight + window.scrollY;
        let documentHeight = document.body.offsetHeight;

        if (scrollPosition >= documentHeight) {
            @this.call('loadMore');
        }
    });
</script>
@endscript
