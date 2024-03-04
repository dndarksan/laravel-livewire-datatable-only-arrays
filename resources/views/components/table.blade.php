<table class="table table-bordered table-striped small table-sm">
    <thead>
        <tr>
            {{ $head }}
        </tr>

    </thead>
    <tbody>
        @isset($searchInputs)
        <tr class="table-secondary">
            {{ $searchInputs }}
        </tr>
        @endisset
        {{ $body }}
    </tbody>
</table>
