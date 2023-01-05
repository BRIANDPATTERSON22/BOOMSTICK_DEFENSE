
    @if (session('success'))
        <div class="box-header">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="box-header">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif
    @if (session('info'))
        <div class="box-header">
            <div class="alert alert-info">{{ session('info') }}</div>
        </div>
    @endif
