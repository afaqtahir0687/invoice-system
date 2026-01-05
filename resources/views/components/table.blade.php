<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table-modern']) }}>
        <thead>
            <tr>
                {{ $thead }}
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
