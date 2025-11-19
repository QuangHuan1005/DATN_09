<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h4 class="card-title mb-2 d-flex align-items-center gap-2">
                    {{ $title ?? 'Statistic' }}
                </h4>
                <p class="text-muted fw-medium fs-22 mb-0">
                    {{ $value ?? '0' }}
                </p>
            </div>
            <div>
                <div class="avatar-md bg-primary bg-opacity-10 rounded">
                    <iconify-icon icon="{{ $icon ?? 'solar:chart-2-bold-duotone' }}"
                        class="fs-32 text-primary avatar-title"></iconify-icon>
                </div>
            </div>
        </div>
    </div>
</div>
