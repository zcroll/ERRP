<ul class="flex items-center justify-between mt-4 text-center">
    @foreach ($statuses as $status => $count)
        @if($status !== 'processing')
            <li class="pb-2">
                <div class="font-semibold">{{ ucfirst($status) }}</div>
                <div class="text-sm text-red-600-600">{{ $count }}</div>
            </li>
        @endif
    @endforeach
</ul>
