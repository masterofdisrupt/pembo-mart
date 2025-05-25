<div class="col-md-3">
    <div class="box-btn">
        <div class="stat-value">
            @if(Str::contains(strtolower($label), 'amount'))
                ₦{{ $formatted }}
            @else
                {{ $formatted }}
            @endif
        </div>
        <div class="stat-label">{{ $label }}</div>
    </div>
</div>
